<?php

namespace Atomic\Database\Engines;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;
use Atomic\Database\DatabaseEngine;
use Atomic\Exceptions\ConnectionFailureException;
use Atomic\Exceptions\RedisCommandExecutionException;

class Redis extends DatabaseEngine {

	protected $connection;

	/*	Retrieves an instance of the redis
	 *	server based on configuration data
	 *
	 *	@returns object New Redis Wrapper Instance
	 */

	public static function getInstance() {
		return new Redis();
	}

	/*	Opens new Redis Server Connection and
	 *	requires some Configuration data.
	 *
	 *	@returns object New Redis Object
	 *	@throws ConnectionFailureException
	 */

	public function __construct() {
		// Open New Redis Connection
		$this->connection = @fsockopen(
			Config::getRequiredVal('redis', 'host'), 
			Config::getRequiredVal('redis', 'port'),
			$errno, $errstr);

		// Test Connection
		if(! $this->connection) {
			throw new ConnectionFailureException(
				"Could not connect to Redis");
		}
	}

	/*
	 *	Destroys Redis Server Connection
	 */

	public function __destruct() {
		fclose($this->connection);
	}

	/*	Executes command sent to redis server
	 *	
	 *	@params $command The Redis Server Command to Execute
	 *	@return mixed Value Returned from Redis Server
	 *	@throws RedisCommandExecutionException
	 */

	public function command($command) {
		try {
			// Send command to Redis Server
			fwrite($this->connection, $command);
		}
		catch(RedisCommandExecutionException $e) {
			throw new RedisCommandExecutionException(
				$e->getMessage());
		}
		// Return Redis reply
		return $this->getRedisReply();
	}

	/*	Retreive reply from Redis Server
	 *	based on supplied command.
	 *
	 * @return mixed Reply from Redis Server
	 */

	public function getRedisReply() {
		// Read resonse from Redis Server
		$reply = trim(fgets($this->connection, 512));
		return $reply;
	}
}