<?php

namespace Atomic\Utilities;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;

class ShutdownHandler {

	protected static $_registered;

	/**
	 * Properly Shutsdown Atomic by deleting
	 * extra files left in the /tmp directory,
	 * and it closes any open file pointers
	 * to the error log file.
	 */

	public static function shutdownAtomic() {
		// Shuffle through tmp folder and delete existing files
		$tmp_path = Config::getBasePath() . "/tmp";
		if(is_dir($tmp_path)) {
			$dh = opendir($tmp_path);
			while($file = readdir($dh)) {
				clearstatcache();
				unlink($tmp_path . "/" . $file);
			}
			closedir($dh);
		}
		
		// Close any open file pointers in the log file
		$log_path = Config::getRequiredVal("app", "log_file_path") ?:
			Config::getBasePath() . "/app/logs/errors.log";
		if(is_file($log_path) && file_exists($log_path)) {
			$fh = fopen($log_path);
			flock($fh, LOCK_UN);
			fclose($fh);
		}
	}
	
	/**
	 * Registers the Shutdown Handler
	 */
	
	public static function registerShutdown() {
		static::$_registered
			= register_shutdown_function(function() {
			static::shutdownAtomic();
		});
	}
}