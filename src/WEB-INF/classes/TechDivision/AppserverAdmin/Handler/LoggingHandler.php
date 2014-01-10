<?php

/**
 * TechDivision\AppserverAdmin\Handler\LoggingHandler
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */
namespace TechDivision\AppserverAdmin\Handler;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use TechDivision\MessageQueueClient\Queue;
use TechDivision\MessageQueueClient\Messages\StringMessage;
use TechDivision\MessageQueueClient\QueueConnectionFactory;

/**
 * A Ratchet websocket handler that sends new log messages 
 * over a websocket to the admin GUI.
 * 
 * @package TechDivision\AppserverAdmin
 * @copyright Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license http://opensource.org/licenses/osl-3.0.php
 *          Open Software License (OSL 3.0)
 * @author Tim Wagner <tw@techdivision.com>
 */
class LoggingHandler implements MessageComponentInterface
{
    
    /**
     * Path and name of the server's error log file.
     * 
     * @var unknown
     */
    const ERROR_LOG = '/opt/appserver/var/log/appserver-errors.log';
    
    /**
     * Path and name of the server's access log file.
     * 
     * @var unknown
     */
    const ACCESS_LOG = '/opt/appserver/var/log/appserver-access.log';

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
     * Initializes the message handler with the container.
     *
     * @return void
     */
    public function __construct()
    {
        
        // initialize the object storage for the client connections
        $this->clients = new \SplObjectStorage();
        
        // initialize the connection and the session
        $queue = Queue::createQueue("queue/logging");
        $connection = QueueConnectionFactory::createQueueConnection();
        $session = $connection->createQueueSession();
        $sender = $session->createSender($queue);
        
        // send log file to publish messages for
        $message = new StringMessage(self::ERROR_LOG);
        $send = $sender->send($message, false);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\ComponentInterface::onOpen()
     */
    public function onOpen(ConnectionInterface $conn)
    {
        // connect the client and send the last ten messages
        $this->clients->attach($conn, 0);
        foreach ($this->lastTenLines as $msg) {
            $conn->send(trim($msg));
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\ComponentInterface::onClose()
     */
    public function onClose(ConnectionInterface $conn)
    {
        error_log("Now closing connection");
        $this->clients->detach($conn);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\MessageInterface::onMessage()
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        
        // stack the message
        array_unshift($this->lastTenLines, trim($msg));
        
        // check if the stack has at least 11 elements
        if (sizeof($this->lastTenLines) > 10) { // if yes, pop the last one
            array_pop($this->lastTenLines);
        }
        
        // send the message to all connected clients
        foreach ($this->clients as $client) {
            if ($from != $client) { // don't return messages to sender
                $client->send(trim($msg));
            }
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\ComponentInterface::onError()
     */
    public function onError(ConnectionInterface $conn,\Exception $e)
    {
        error_log($e->__toString());
        $conn->close();
    }
}