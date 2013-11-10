<?php

//extand memory limit
ini_set('memory_limit','512M');
ini_set('max_execution_time','0');

//load functions
include('functions.php');

//load classes
if(!class_exists('NHL_Streaks'))
	include('nhl_streaks.class.php');

if(!class_exists('simple_html_dom_node'))
	include('simple-html-dom.class.php');

//define constants
define('NHL_STREAKS_PATH', 			dirname(dirname (__FILE__)) );
define('NHL_STREAKS_PATH_INC',		NHL_STREAKS_PATH . '/includes');
define('NHL_STREAKS_PATH_ASSETS',	NHL_STREAKS_PATH . '/assets');
define('NHL_STREAKS_PATH_JS',		NHL_STREAKS_PATH_ASSETS . '/js');
define('NHL_STREAKS_PATH_CSS',		NHL_STREAKS_PATH_ASSETS . '/css');

define('NHL_STREAKS_CACHE_PATH', 	NHL_STREAKS_PATH . '/cache');
define('NHL_STREAKS_CACHE_EXPIRE',	3600*24*5);

define('NHL_STREAKS_URI',			'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
define('NHL_STREAKS_ASSETS', 	NHL_STREAKS_URI . 'assets');
define('NHL_STREAKS_URI_CSS', 		NHL_STREAKS_URI_ASSETS . '/css');
define('NHL_STREAKS_URI_JS', 		NHL_STREAKS_URI_ASSETS . '/js');
