<?php

namespace Atomic\Database\Engines;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;
use Atomic\Database\DatabaseEngine;
use Atomic\Database\Exceptions\ConnectionFailureException;

class SQLite extends DatabaseEngine {

	/*	Retreives an Instance of the SQLite
	 *	database engine.
	 *
	 *	@returns object SQLite PDO Object
	 *	@throws ConnectionFailureException
	 */

	public static function getInstance() {
		// Check if a Database Instance Doesn't Already Exist
		if(! static::$_instance) {
			$sqlite_file = Config::getRequiredVal('db', 'sqlite_file');
			try {
				$dsn = "sqlite:{$sqlite_file}";
				static::$_instance = new PDO($dsn, null, null);
			}
			catch(PDOException $e) {
				throw new ConnectionFailureException(
					$e->getMessage());
			}
		}
		return static::$_instance;
	}
}