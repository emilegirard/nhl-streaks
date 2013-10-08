<?php

//extand memory limit
ini_set('memory_limit','256M');

//load functions
include('functions.php');

//load classes
include('streaks.class.php');
include('simple-html-dom.class.php');

//define constants
define('PATH', 			dirname(dirname (__FILE__)) );
define('PATH_CACHE', 	PATH . '/cache');
define('PATH_INC',		PATH . '/includes');
define('PATH_ASSETS',	PATH . '/assets');
define('PATH_JS',		PATH_ASSETS . '/js');
define('PATH_CSS',		PATH_ASSETS . '/css');
define('CACHE_EXPIRE',	3600);

define('URI',			'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
define('URI_ASSETS', 	URI . 'assets');
define('URI_CSS', 		URI_ASSETS . '/css');
define('URI_JS', 		URI_ASSETS . '/js');