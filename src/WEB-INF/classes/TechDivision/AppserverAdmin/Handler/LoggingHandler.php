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
use TechDivision\PersistenceContainerClient\Context\Connection\Factory;
use TechDivision\Example\Entities\Sample;
use TechDivision\AppserverAdmin\Utilities\Tail;

/**
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
     * The log tailer.
     * 
     * @var \TechDivision\AppserverAdmin\Utilities\Tail
     */
    protected $tail;

    /**
     * Initializes the message handler with the container.
     *
     * @return void
     */
    public function __construct()
    {
        
        // initialize the object storage for the client connections
        $this->clients = new \SplObjectStorage();
        
        // initialize the log tailer
        $this->tail = new Tail('/tmp/testfile.json');
        $this->tail->addFile('/opt/appserver/var/log/appserver-errors.log');
        $this->tail->addFile('/opt/appserver/var/log/appserver-access.log');
        
        // callback when a new message has been written to the log file
        $this->tail->listen(function ($filename, $chunk)
        {
            
            // extract the log message
            foreach (explode("\n", $chunk) as $text) {
                $text = trim($text);
                if (empty($text)) {
                    continue;
                }
                
                // callback message
                $this->onLogMessage("$filename - $text" . PHP_EOL);
            }
        });
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\ComponentInterface::onOpen()
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn, 0);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\ComponentInterface::onClose()
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * Sends the log messages to all registered clients.
     * 
     * @param string $message The log message to send
     * @return void
     */
    public function onLogMessage($message)
    {       
        foreach ($this->clients as $client) {
            $client->send(trim($message));
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Ratchet\MessageInterface::onMessage()
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        // do nothing here;
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