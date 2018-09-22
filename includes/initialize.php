<?php

/*
 * This is where you declare all your global constants
 * and include class objects
 * Global settings are also done here.
 */

/* GLOBAL TIMEZONE SETTINGS
*********************************************************************/
date_default_timezone_set("Africa/Accra");


/********************************************************************
     APPLICATION CONSTANTS
********************************************************************/
define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', dirname(__DIR__));
define("HTTP_TYPE", (isset($_SERVER['HTTPS'][0]) && $_SERVER['HTTPS'] == 'on') ? "https" : "http");

define("APP_URI", HTTP_TYPE . "://".$_SERVER['HTTP_HOST']);

// UPLOAD FILES DIR CONSTANTS
define('INC_DIR', APP_ROOT.DS."includes");
define('TEM_DIR', APP_ROOT.DS."templates");
define('LOG_DIR', APP_ROOT.DS."logs");



/* ERROR REPORTING
   @ Make sure it is set 'false' when in production
********************************************************************/
define("DEBUG_MODE", true); //set to off when in production
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', LOGS_DIR.DS."errors.log");
}

/*******************************************************************
  INCLUDES FILES
********************************************************************/
// Connection file
require_once(INC_DIR.DS.'connect.php');

// Core Objects 
require_once(INC_DIR.DS.'class.util.php');
require_once(INC_DIR.DS.'class.database.php');
// require_once(INC_DIR.DS.'class.globalobject.php');
// require_once(INC_DIR.DS.'class.session.php');
// require_once(INC_DIR.DS.'class.secure.php');
// require_once(INC_DIR.DS.'class.customdate.php');
// require_once(INC_DIR.DS.'class.settings.php');
// require_once(INC_DIR.DS.'class.pagination.php');

// Controller Classes
// require_once(INC_DIR.DS.'class.country.php');
// require_once(INC_DIR.DS.'class.admin.php');
?>