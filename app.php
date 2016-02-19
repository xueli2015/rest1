<?php

	/************************************/
	/*  LOAD SETUP                      */
	/************************************/

	/*********************************/
	/*  BASIC SETUP                  */
	/*********************************/

	// DB connection parameters
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'mcs2013');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'root');
	
	/************************************/
	/*  ADVANCED SETUP - LANGUAGES      */
	/************************************/
	
	// Setup default language for the site
	define('DEFAULT_LANGUAGE', 'en');
	
	// Setup the default text direction for the site (ltr, rtl, auto)
	define('DEFAULT_DIRECTION', 'ltr');

	// JWT key
	define('JWT_KEY', 'shoppingrun');

	/************************************/
	/*  Locations                       */
	/************************************/
	// Locations of apps and sites
	define('APP_LOCATION', '../');
	define('DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"]);
   
   
	/************************************/
	/*  Data Access Objects             */
	/************************************/
    require_once 'db/DB.php';
	require_once 'db/customer.php';
	require_once 'db/menu.php';
	require_once 'db/permission.php';
	require_once 'db/role.php';
	require_once 'db/user.php';
	
	
	/************************************/
	/*  External Libraries              */
	/************************************/
	// include external libs (via composer)
	require 'vendor/autoload.php';

    // include non-composer external libs
	require_once 'libs/PasswordHash.php';
	//require_once 'libs/class-php-ico.php';
	//require_once 'libs/IpnListener.php';
	//require_once 'libs/simple_html_dom.php';
	
	// include libs
	require_once 'libs/Token.php';
	require_once 'libs/Utilities.php';
	//require_once 'libs/Webhooks.php';
	//require_once 'libs/Validator.php';
	//require_once 'libs/Image.php';
	//require_once 'libs/Publish.php';
	
	/************************************/
	/*  REST Objects                    */
	/************************************/
	require_once 'rest/test.php';
    //require_once 'rest/app.php';
    require_once 'rest/customer.php';
    require_once 'rest/example.php';
    require_once 'rest/user.php';
?>