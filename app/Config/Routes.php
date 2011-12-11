<?php

namespace App\Config;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;
use Atomic\Controllers\Dispatcher;

Dispatcher::addRule("", array(
	"controller" => "Welcome",
	"function" => "yoyowazguch",
	"method" => Dispatcher::GET
));

Dispatcher::addRule("/ohai", array(
	"controller" => "Welcome",
	"function" => "main",
	"method" => Dispatcher::GET
));

Dispatcher::init();