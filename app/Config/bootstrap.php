<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));
/**
 * Define global variable for ple chat
 */
Configure::write('userservice_token','XB6a69B8');
Configure::write('host_name','@daffodil-109');
Configure::write('room_host_name','@conference.daffodil-109');
Configure::write('chatserver_host','http://14.141.28.114:9090');
Configure::write('bosh_url','http://14.141.28.114:7070/http-bind/?%3Cbody%20/%3E');
Configure::write('site_url','http://14.141.28.114:2225/ple_vers11');

//Configure::write('userservice_token','H6kU03a6');
//Configure::write('host_name','@gajendra-pc');
//Configure::write('room_host_name','@conference.gajendra-pc');
//Configure::write('chatserver_host','http://172.18.2.245:9090');
//Configure::write('bosh_url','http://172.18.2.245:7070/http-bind/?%3Cbody%20/%3E');

Configure::write('limit', '10');
Configure::write('mail-from', 'yogendra.singh@daffodilsw.com');
//date_default_timezone_set('America/Los_Angeles');
date_default_timezone_set('Asia/Calcutta');

Configure::write('extra_meetingtime', '1800'); //Time is in seconds, 30 minutes is given can be changed. 

/**
 * Define twitter setting
 */
Configure::write('CONSUMER_SECRET','9V4aBltcUXnagJYwFtyh5gX8tEOC3q2eID9mMSqOy8');
Configure::write('CONSUMER_KEY','YDY8DnBqGwOCX3h2kXy6Nw');
//Configure::write('OAUTH_CALLBACK','http://172.18.2.195/twitteroauth/callback.php');
Configure::write('oauth_token','115992765-FuQmwbE0ohmSYXse5OcAKiJpAeHpUDxW1sRYA35F');
Configure::write('oauth_token_secret','lBNZLn4qbxJIlocOsbRRX76gIQ7mjCJYOCxu5fSGxLNZn');

/**
 * Define the facebook setting
 */

Configure::write('APPID', '242928729213843');
Configure::write('APPSECRET', '2273fb2be68212bf7c7fd044be062a83');

//email setting
Configure::write('email_from', 'yogendra.singh@daffodilsw.com');
Configure::write('email_title', 'PLE');
//email address for mail sending fail case(as a admin email)
Configure::write('reply_to', 'abhishek.gupta@daffodilsw.com');
//feed reader setting
Configure::write('feed_count', 5);

//logout url.
Configure::write('logout_url', 'http://14.141.28.114:2225/plesite_vers11/login.php');
//course separator
Configure::write('course_separator', '-');
Configure::write('chat_password', '123456');

Configure::write('odu_url','http://14.141.28.114:2225/ple_vers11');
Configure::write('odu_url1','http://ple.com');
//last date(in future)
Configure::write('future_date', '03/22/2034');
Configure::write('future_date_formated', '2034-03-22');
//session separator
Configure::write('session_separator', '_');