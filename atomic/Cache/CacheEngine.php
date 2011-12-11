<?php

namespace Atomic\Cache;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

interface CacheEngine {

	/*	Sets a new cache value only if
	 *	it isn't already set
	 *
	 *	@params $key The Key to Add
	 *	@params $value The Value of the Key
	 *	@params $expire The Seconds Until Action Expires
	 *	@return boolean Successful Add or Not
	 */

	public function add($key, $value, $expire);

	/*	Replaces a Value already set
	 *
	 *	@params $key The Key to Replace
	 *	@params $value The Value of the Key
	 *	@params $expire The Seconds Until Action Expires
	 *	@return boolean Successfull Replace or Not
	 */

	public function replace($key, $value, $expire);

	/*	Sets a new cache value whether or
	 *	not key is set
	 *
	 *	@params $key The Key to Add
	 *	@params $value The Value of the Key
	 *	@params $expire The Seconds Until Action Expires
	 *	@return boolean Successful Set or Not
	 */

	public function set($key, $value, $expire);

	/*	Gets Value of Specified Key
	 *
	 *	@params $key The Key to Find
	 *	@return mixed Value of the Key
	 */

	public function get($key);

	/*	Increments a stored integer by specified
	 *	increment rate
	 *
	 *	@params $key The Key (int) to Increment
	 *	@params $num The Rate at which to Increment
	 *	@return int New Integer Value
	 */

	public function increment($key, $num=1);

	/*	Decrement a stored integer by specified
	 *	decrement rate
	 *
	 *	@params $key The Key (int) to Decrement
	 *	@params $num The Rate at which to Decrement
	 *	@return int New Integer Value
	 */

	public function decrement($key, $num=1);

	/*	Delete a specified key from the
	 *	cache.
	 *
	 *	@params $key The Key to Delete From
	 *	@return boolean Successful Deletion
	 */

	public function delete($key);

	/*	Removes every record from the cache.
	 *
	 *	@return boolean Successful Flush
	 */

	public function flushCache();

	/*	Returns an Array with information
	 *	about the cache.
	 *
	 *	@returns array Information about Cache
	 */

	public function getStats();

}