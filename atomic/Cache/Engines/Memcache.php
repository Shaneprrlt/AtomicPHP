<?php

namespace Atomic\Cache\Engines;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Memcache;
use Atomic\Config\Config;
use Atomic\Cache\CacheEngine;
use Atomic\Cache\Exceptions\ConnectionException;

class Memcache implements CacheEngine {

	protected $mc;

	public function __construct() {

		try {

			$mc = new Memcache();
			$host = Config::getVal('cache', 'memcache_host') ?: 'localhost';
			$port = Config::getVal('cache', 'memcache_port') ?: '11211';
			$mc->addServer($host, $port);
			$this->mc = $mc;
		}
		catch(ConnectionException $e) {

			throw new ConnectionException($e->getMessage());
		}
	}

	public function __destruct() {

		$this->mc->close();
	}

	public function add($key, $value, $expire) {

		return $this->mc->add($key, $value, false, $expire);
	}

	public function replace($key, $value, $expire) {

		return $this->mc->replace($key, $value, false, $expire);
	}

	public function set($key, $value, $expire) {

		return $this->mc->set($key, $value, false, $expire);
	}

	public function get($key) {

		return $this->mc->get($key);
	}

	public function increment($key, $num=1) {

		return $this->mc->increment($key, $num);
	}

	public function decrement($key, $num=1) {

		return $this->mc->decrement($key, $num);
	}

	public function delete($key) {

		return $this->mc->delete($key, 0);
	}

	public function flushCache() {

		return $this->mc->flush();
	}

	public function getStats() {

		return $this->mc->getStats();
	}

}