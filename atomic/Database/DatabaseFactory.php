<?php

namespace Atomic\Database;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Atomic\Config\Config;
use Atomic\Database\Exceptions\EngineNotFoundException;
 
class DatabaseFactory {

	/*	Retrieves an Instance of the DatabaseEngine
	 *	specified in the Configuration File.
	 *
	 *	@returns object PDO Object of Specified Engine
	 *	@throws EngineNotFoundException
	 */

	public static function factory() {
		// Find Engine Classname
		$engine_namespace = 'Atomic\Database\Engines\\';
		$engine = Config::getRequiredVal('db', 'engine');
		$class_name = $engine_namespace . $engine;
		// Check if Class Exists and Load it
		if(@class_exists($class_name)) {
			return $class_name::getInstance();
		}
		else {
			throw new EngineNotFoundException(
				"Engine '{$engine}' is not supported");
		}
	}
}