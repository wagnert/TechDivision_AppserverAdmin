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
        
        // wait to seconds to allow WS server beeing started
        sleep(2);
        
        // set the file to log, or created it if not already available
        if (!file_exists($filename = $message->getMessage())) {
            touch($filename);
        }
        
        // initialize composer autoloader
        require __DIR__ . '/../../../../vendor/autoload.php';
        
        // create the socket connection
        $client = new \Wrench\Client(self::LOGGING_WEBSOCKET, self::LOGGING_ORIGIN);
        $client->connect();
            
        // init file info object
        $fileInfo = new \SplFileInfo($filename);
                
        // init last size var
        $lastSize = $fileInfo->getSize();
        if (($remainder = $lastSize - 10) > 10) {
            $remainder = 10;
        }
            
        // start with the last 10 lines
        $lastSize =  $lastSize - $remainder;
        
        // go into loop
        while (true) {
        
            // clear file info cache
            clearstatcache(false, $filename);
        
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
                        $client->sendData(trim($line));
                    }
                }
                
                // save current size to check for new content
                $lastSize = $fileInfo->getSize();
            }
        }
    }
}