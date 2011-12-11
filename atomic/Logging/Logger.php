<?php

namespace Atomic\Logging;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;
use Atomic\Logging\Exceptions\LogFileNotFoundException;
use Atomic\Logging\Exceptions\LogFileNotWriteableException;

class Logger {

	/**
	 * Writes a new message to the log file
	 * @param $_message the message to log
	 * @param $_file the file the trigger occured
	 * @param $_line the line number of the file the trigger occured
	 */
	 
	public static function write($_message, $_file, $_line) {
		// Construct the Log File
		$_log_file = isset(Config::getVal('app', 'log')) ? 
			Config::getVal('app', 'log') : Config::getBasePath() 
			. "/app/Logs/errors.log";
		if(file_exists($_log_file)) {
			$_handle = fopen($_log_file, "a");
			// Check if the Log File is Clear to Write to
			if(flock($handle, LOCK_EX)) {
				// Generate the Error String
				$_error_str = date("[d-m-Y h:i:s]")
					. "({$_file}:{$_line}) {$_message}";
				// Write error and close the handle
				fwrite($_handle, $_error_str);
				fclose($_handle);
			}
			else {
				// Throw Exception if the Log File is not Writeable
				throw new LogFileNotWriteableException(
					"Could not open log file.");
			}	
		}
		else {
			// Throw Exception if the Log File does not exist
			throw new LogFileNotFoundException(
				"Could not find log file.");
		}
	}
}