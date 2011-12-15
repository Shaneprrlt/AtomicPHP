<?php

namespace Atomic\Database\Engines;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Atomic\Config\Config;
use Atomic\Database\DatabaseEngine;
use Atomic\Database\Exceptions\ConnectionFailureException;

class MySQL extends DatabaseEngine {

	/*	Retreives an Instance of the MySQL
	 *	database engine.
	 *
	 *	@returns object MySQL PDO Object
	 *	@throws ConnectionFailureException
	 */

	public static function getInstance() {
		// Check if a Database Instance Doesn't Already Exist
		if(! static::$_instance) {
			// Get Connection Information from Configuration
			$host = Config::getRequiredVal('db', 'host');
			$port = Config::getRequiredVal('db', 'port');
			$user = Config::getRequiredVal('db', 'user');
			$pass = Config::getRequiredVal('db', 'pass');
			$name = Config::getRequiredVal('db', 'name');
			try {
				// Open a new Connection
				$dsn = "mysql:host={$host};port={$port};dbname={$dbname}";
				static::$_instance = new PDO($dsn, $user, $pass);
			}
			catch(PDOException $e) {
				throw new ConnectionFailureException($e->getMessage());
			}
		}
		return static::$_instance;
	}
}