<?php

namespace Atomic\Autoloader;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Atomic\Config\Config;

class Autoloader {

	protected static $_registered = false;
	
	/**
	 *	Loads a class by splitting the namespace
	 *	into the file system path.
	 * 	@param $class The Absolute Namespace Class
	 */
	 
	public static function loadClass($_class) {
		$_class = ltrim($_class, "\\");
		$_file_path = Config::getBasePath()
			. "/" . str_replace("\\", "/", $_class);
		$_file_path .= ".php";
		return !!include($_file_path);	
	}
	
	/**
	 *	Registers the Autoloader to Load Classes
	 *	with the namespace.
	 */
	
	public static function autoloadRegister() {
		// If Registration Has Already Been Set Return
		if(static::$_registered) {
			return false;
		}
		// Register the Autloader
		static::$_registered = spl_autoload_register(
			"\Atomic\Autoloader\Autoloader::loadClass");
		return static::$_registered;
	}
}