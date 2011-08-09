<?php

namespace Core\System\Database\Engines;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Core\System\Config\Config;
use Core\System\Database\DatabaseEngine;
use Core\System\Database\Exceptions\ConnectionFailureException;
use Core\System\Database\Exceptions\QueryFailureException;

class MySQL extends DatabaseEngine {

	/*	Retreives an Instance of the MySQL
	 *	database engine.
	 *
	 *	@returns object MySQL PDO Object
	 *	@throws ConnectionFailureException
	 */

	public static function getInstance() {
	
		if(! static::$_instance) {
			
			$host = Config::getRequiredVal('db', 'host');
			$port = Config::getRequiredVal('db', 'port');
			$user = Config::getRequiredVal('db', 'user');
			$pass = Config::getRequiredVal('db', 'pass');
			$name = Config::getRequiredVal('db', 'name');
			
			try {
				
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