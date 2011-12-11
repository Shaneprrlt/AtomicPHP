<?php

namespace Atomic\Atomic;

use DateTime;

class Timer {
	
	protected static $_timers = array();
	protected static $_results = array();
	
	/**
	 * Starts a stopwatch with a given title
	 * @param $title The Title of the Stopwatch
	 */
	
	public static function start($title) {
		if(!isset(static::$_timers[$title])) {
			static::$_timers[$title] = microtime();
		}
	}
	
	/**
	 * Stops all the current timers that are running.
	 */
	
	public static function stop() {
		foreach(static::$_timers as $title => $time) {
			$old_time = $time;
			$current_time = microtime();
			$time_diff = $current_time - $old_time;
			$time = date("h:i:s:u", $time_diff);
			static::$_results[$title] = $time;
			unset(static::$_timers[$title]);
		}
	}
	
	/**
	 * Gets the time of a specific stopwatch
	 * @param $title The Title of the Stopwatch
	 * @return The recorded time of the stopwatch
	 */
	
	public static function getTime($title) {
		if(isset(static::$_results[$title])) {
			return static::$_results[$title];
		}
	}
}