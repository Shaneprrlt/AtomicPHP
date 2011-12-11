<?php

namespace Atomic\Config;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Atomic\Config\Exceptions\ConfigKeyNotFoundException;
use Atomic\Config\Exceptions\InvalidPathException;

class Config {

	protected static $_config = array();
	protected static $_base_path;
	
	public static function loadConfigFile($_file_path) {
		if(file_exists($_file_path)) {
			$_file_contents = file_get_contents($_file_path);
			$_config_data = json_decode($_file_contents, true);
			static::$_config = array_merge(static::$_config, $_config_data);
		}
	}

	/*	Set a Value into the config array. This is
	 *	how you store global data and `constants`
	 *	across your application.
	 *
	 *	@params $key The top-level associative key
	 *	@params $sub The second-level associative key
	 *	@params $value The value of the second-level associative key
	 *	@return boolean	Successful save or not
	 */

	public static function setVal($key, $sub, $value) {
		if(! static::$_config[$key][$sub]) {
			if(static::$_config[$key][$sub] = $value) {
				return true;
			}
		}
	}

	/*	Returns a value from the config array.This is
	 *	how you return global data and `constants`
	 *	across your application.
	 *
	 *	@params $key The top-level associative key
	 *	@params $sub The second-level associative key
	 *	@params $required Throws and error if key not found
	 *	@throws ConfigKeyNotFoundException
	 *	@return mixed Returns a value depending on requested key
	 */

	public static function getVal($key, $sub, $required = false) {
		if(static::$_config[$key][$sub]) {
			return static::$_config[$key][$sub];
		}
		else if($required) {
			throw new ConfigKeyNotFoundException("Config Key Not Found: [{$key}][{$sub}]");
		}
	}

	/*	Returns a value from the config array. This is
	 *	the same as getVal only an error is thrown if
	 *	the requested key isn't set.
	 *
	 *	@params $key The top-level associative key
	 *	@params $sub The second-level associative key
	 *	@throws ConfigKeyNotFoundException
	 *	@return mixed Returns a value depending on requested key
	 */

	public static function getRequiredVal($key, $sub) {
		return static::getVal($key, $sub, true);
	}
	
	/**
	 *	Sets the Absolute Base Path of the Web Application
	 *	This is usually set when the application is created 
	 */
	 
	 public static function setBasePath($base_path) {
	 	// Remove any trailing slashes on Path
	 	while($base_path{strlen($base_path) - 1} == "/") {
	 		$base_path = substr($base_path, 0, strlen($base_path) - 1);
	 	}
	 	
	 	// Set Base Path
	 	static::$_base_path = $base_path;
	 }

	/*	Returns the application base path
	 *
	 *	@return string Application's Base Path
	 */

	public static function getBasePath() {
		return static::$_base_path;
	}
}