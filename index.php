<?php

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

// Include Autoloader
include dirname(realpath(__FILE__))
	. "/atomic/atomic.inc.php";

use Atomic\Config\Config;
use Atomic\Controllers\Dispatcher;
use Atomic\Utilities\ShutdownHandler;

// Set Configuration and Load Application.config
Config::setBasePath( dirname(realpath(__FILE__)) );
Config::loadConfigFile(Config::getBasePath()
	. "/app/Config/Application.config");
	
// Get the Routes from /App/Config/Routes.php
include Config::getBasePath() . "/app/Config/Routes.php";
ShutdownHandler::registerShutdown();

?>