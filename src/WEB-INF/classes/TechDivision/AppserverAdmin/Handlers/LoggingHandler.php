<?php

/**
 * TechDivision\AppserverAdmin\Handlers\LoggingHandler
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Appserver
 * @package    TechDivision_AppserverAdmin
 * @subpackage Handlers
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
namespace TechDivision\AppserverAdmin\Handlers;

use Ratchet\ConnectionInterface;
use TechDivision\MessageQueueClient\MessageQueue;
use TechDivision\MessageQueueClient\QueueConnectionFactory;
use TechDivision\MessageQueueProtocol\Messages\StringMessage;
use TechDivision\WebSocketContainer\Handlers\HandlerConfig;
use TechDivision\WebSocketContainer\Handlers\AbstractHandler;

/**
 * A Ratchet websocket handler that sends new log messages
 * over a websocket to the admin GUI.
 *
 * @category   Appserver
 * @package    TechDivision_AppserverAdmin
 * @subpackage Handlers
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
class LoggingHandler extends AbstractHandler
{

    /**
     * Path and name of the server's error log file.
     *
     * @var string
     */
    const ERROR_LOG = 'appserver-errors.log';

    /**
     * Path and name of the server's access log file.
     *
     * @var string
     */
    const ACCESS_LOG = 'appserver-access.log';

    /**
     * The connected web socket clients.
     *
     * @var \SplObjectStorage
     */
    protected $clients;

    /**
     * The persistence container connection to use.
     *
     * @var \TechDivision\PersistenceContainerClient\Interfaces\Connnection
     */
    protected $connection;

    /**
     * The persistence container session to use.
     *
     * @var \TechDivision\PersistenceContainerClient\Interfaces\Session
     */
    protected $session;

    /**
     * Array that contains the last ten log entries.
     *
     * @var array
     */
    protected $lastTenLines = array();

    /**
     * Flag to identify if the logger has been connected or not.
     *
     * @var boolean
     */
    protected $messageSent = false;

    /**
     * Initializes the message handler with the container.
     *
     * @param \echDivision\WebSocketContainer\Handlers\HandlerConfig $config The handler configuration
     *
     * @return void
     */
    public function init(HandlerConfig $config)
    {

        // call parent init() method
        parent::init($config);

        // initialize the object storage for the client connections
        $this->clients = new \SplObjectStorage();
    }

    /**
     * This method will be invoked when a new client has to be connected
     * and attaches the client to the handler.
     *
     * @param \Ratchet\ConnectionInterface $conn The ratchet connection instance
     *
     * @return void
     * @see \Ratchet\ComponentInterface::onOpen()
     */
    public function onOpen(ConnectionInterface $conn)
    {
        // log the new connection
        $this->getApplication()->getInitialContext()->getSystemLogger()->debug("New connection");

        // check if the message to connect the logger has already been sent
		if ($this->messageSent === false) {

	        // initialize the connection and the session
	        $queue = MessageQueue::createQueue("queue/logging");
	        $connection = QueueConnectionFactory::createQueueConnection();
	        $session = $connection->createQueueSession();
	        $sender = $session->createSender($queue);

	        // create the log file path
	        $relativeLogFilePath = DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . self::ERROR_LOG;
	        $absoluteLogFilePath = $this->getApplication()->getBaseDirectory($relativeLogFilePath);

	        // send log file to publish messages for
	        $message = new StringMessage($absoluteLogFilePath);
	        $send = $sender->send($message, false);

	        // set the flag that the logger has been connected
	        $this->messageSent = true;
	    }

        // connect the client and send the last ten messages
        $this->clients->attach($conn, 0);
        foreach ($this->lastTenLines as $msg) {
            $conn->send(trim($msg));
        }
    }

    /**
     * This method will be invoked when the client connection will be closed.
     *
     * @param \Ratchet\ConnectionInterface $conn The ratchet connection instance
     *
     * @return void
     * @see \Ratchet\ComponentInterface::onClose()
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->getApplication()->getInitialContext()->getSystemLogger()->debug("Closing connection");
        $this->clients->detach($conn);
    }

    /**
     * This method will be invoked when a new message has to be send
     * to the connected clients.
     *
     * @param \Ratchet\ConnectionInterface $from The ratchet connection instance
     * @param string                       $msg  The message to be send to all clients
     *
     * @return void
     * @see \Ratchet\MessageInterface::onMessage()
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {

        // stack the message
        array_unshift($this->lastTenLines, trim($msg));

        // check if the stack has at least 11 elements
        if (sizeof($this->lastTenLines) > 10) {
            // if yes, pop the last one
            array_pop($this->lastTenLines);
        }

        // send the message to all connected clients
        foreach ($this->clients as $client) {
            if ($from != $client) {
                // don't return messages to sender
                $client->send(trim($msg));
            }
        }
    }

    /**
     * The method will be invoked when an error occures
     * during client connection handling.
     *
     * @param \Ratchet\ConnectionInterface $conn The ratchet connection instance
     * @param \Exception                   $e    The exception that leads to the error
     *
     * @return void
     * @see \Ratchet\ComponentInterface::onError()
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->getApplication()->getInitialContext()->getSystemLogger()->error($e->__toString());
        $conn->close();
    }
}
