<?php

/**
 * TechDivision\AppserverAdmin\Servlets\AdminServlet
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\AppserverAdmin\Servlets;

use TechDivision\ServletContainer\Servlets\StaticResourceServlet;
use TechDivision\ServletContainer\Interfaces\Response;
use TechDivision\ServletContainer\Interfaces\Request;

/**
 * A servlet implementation to handle static file requests.
 *
 * @package   TechDivision\ServletContainer
 * @copyright 2013 TechDivision GmbH <info@techdivision.com>
 * @license   Open Software License (OSL 3.0) http://opensource.org/licenses/osl-3.0.php
 * @author    Johann Zelger <jz@techdivision.com>
 */
class AdminServlet extends StaticResourceServlet
{

    /**
     * Tries to load the requested file and adds the content to the response.
     *
     * @param Request  $req The servlet request
     * @param Response $res The servlet response
     *
     * @throws \TechDivision\ServletContainer\Exceptions\PermissionDeniedException
     *      Is thrown if the request tries to execute a PHP file
     * @return void
     */
    public function doGet(Request $req, Response $res)
    {
        // rewrite uri to index.html by default
        $req->setUri($req->getUri() . 'index.html');
        // call parent function
        parent::doGet($req, $res);
    }
}
