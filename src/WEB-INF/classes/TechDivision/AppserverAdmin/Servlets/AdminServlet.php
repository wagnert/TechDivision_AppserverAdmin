<?php

/**
 * TechDivision\AppserverAdmin\Servlets\AdminServlet
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
 * @subpackage Servlets
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */

namespace TechDivision\AppserverAdmin\Servlets;

use TechDivision\ServletContainer\Http\ServletRequest;
use TechDivision\ServletContainer\Http\ServletResponse;
use TechDivision\ServletContainer\Servlets\StaticResourceServlet;

/**
 * The servlet implementation that delivers the admin application.
 * 
 * @category   Appserver
 * @package    TechDivision_AppserverAdmin
 * @subpackage Servlets
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
class AdminServlet extends StaticResourceServlet
{

    /**
     * Tries to load the requested file and adds the content to the response.
     *
     * @param \TechDivision\ServletContainer\Http\ServletRequest  $servletRequest  The request instance
     * @param \TechDivision\ServletContainer\Http\ServletResponse $servletResponse The response instance
     *
     * @return void
     * @throws \TechDivision\ServletContainer\Exceptions\PermissionDeniedException Is thrown if the request tries to execute a PHP file
     */
    public function doGet(ServletRequest $servletRequest, ServletResponse $servletResponse)
    {
        // rewrite uri to index.html by default
        $req->setUri($servletRequest->getUri() . 'index.html');
        // call parent function
        parent::doGet($servletRequest, $servletResponse);
    }
}
