<?php

/**
 * TechDivision\AppserverAdmin\MessageBeans\ImportReceiver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */
namespace TechDivision\AppserverAdmin\MessageBeans;

use TechDivision\MessageQueueClient\Interfaces\Message;
use TechDivision\MessageQueueClient\Receiver\AbstractReceiver;

/**
 * This is the implementation of a logging message receiver that
 * sends log entries a web socket.
 *
 * @package TechDivision\AppserverAdmin
 * @copyright Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license http://opensource.org/licenses/osl-3.0.php
 *          Open Software License (OSL 3.0)
 * @author Tim Wagner <tw@techdivision.com>
 */
class LoggingReceiver extends AbstractReceiver
{
    
    /**
     * The URI of the logging websocket.
     * 
     * @var string
     */
    const LOGGING_WEBSOCKET = 'ws://127.0.0.1:8589/admin/logging';
    
    /**
     * The origin URI.
     * 
     * @var string
     */
    const LOGGING_ORIGIN = 'http://127.0.0.1:8587';

    /**
     * (non-PHPdoc)
     *
     * @see \TechDivision\MessageQueueClient\Interfaces\MessageReceiver::onMessage()
     */
    public function onMessage(Message $message, $sessionId)
    {
        
        // wait to seconds until WebSocket container has been started
        sleep(2);
        
        // initialize composer autoloader
        require $this->getContainer()->getWebappPath() . '/META-INF/vendor/autoload.php';
        
        // connect to the local WebSocket
        $client = new \Wrench\Client(self::LOGGING_WEBSOCKET, self::LOGGING_ORIGIN);
        $client->connect();

        // set the file to log
        $filename = $message->getMessage();

        // init last size var
        $lastSize = 0;
        
        // go into loop
        while (true) {
            
            // clear file info cache
            clearstatcache(false, $filename);
            // init file info object
            $fileInfo = new \SplFileInfo($filename);
            
            // check if size is still the same
            if ($lastSize == $fileInfo->getSize()) {
                // wait internally to avoid cpu load
                usleep(1000);
                // continue with next tick
                continue;
            }
            
            // open file
            $file = $fileInfo->openFile();
            
            // check if file is readable and not locked
            if ($file->isReadable()) {
                // check if goto last size is possible
                if ($file->fseek($lastSize) === 0) {
                    // read till new end of file
                    while ($line = $file->fgets()) {
                        $client->sendData($line);
                    }
                }
                // save current size to check for new content
                $lastSize = $fileInfo->getSize();
            }
        }
    }
}