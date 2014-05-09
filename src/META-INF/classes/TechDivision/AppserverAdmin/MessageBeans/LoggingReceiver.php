<?php

/**
 * TechDivision\AppserverAdmin\MessageBeans\ImportReceiver
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
 * @subpackage MessageBeans
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
namespace TechDivision\AppserverAdmin\MessageBeans;

use TechDivision\MessageQueueProtocol\Message;
use TechDivision\MessageQueue\Receiver\AbstractReceiver;

/**
 * This is the implementation of a logging message receiver that
 * sends log entries a web socket.
 *
 * @category   Appserver
 * @package    TechDivision_AppserverAdmin
 * @subpackage MessageBeans
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 *
 * @MessageDriven
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
     * Will be invoked when a new message for this message bean will be available.
     *
     * @param \TechDivision\MessageQueueClient\Interfaces\Message $message   A message this message bean is listen for
     * @param string                                              $sessionId The session ID
     *
     * @return void
     * @see \TechDivision\MessageQueueClient\Interfaces\MessageReceiver::onMessage()
     */
    public function onMessage(Message $message, $sessionId)
    {

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
                // sleep for 0.1 seconds to lower system load
                usleep(100000);
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
