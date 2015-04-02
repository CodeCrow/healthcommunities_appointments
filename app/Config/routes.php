<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Appointment-specific Routing rules.
 */
	Router::connect('/', array('controller' => 'appointments', 'action' => 'index'));
	Router::connect('/admin', array('controller' => 'appointments', 'action' => 'admin'));
	Router::connect('/thankyou', array('controller' => 'appointments', 'action' => 'thankyou'));
	Router::connect('/app/:name', array('controller' => 'appointments', 'action' => 'index'), array('name'=>'[a-zA-Z0-9\-]+'));
	Router::connect('/app/:name/thankyou', array('controller' => 'appointments', 'action' => 'thankyou'), array('name'=>'[a-zA-Z0-9\-]+'));
	Router::connect('/appointments/view/:print/*', array('controller' => 'appointments', 'action' => 'view'), array('print'=>'print'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
