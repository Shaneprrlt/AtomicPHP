<?php

namespace Atomic\Utilities;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

class FlashData {

	/**
	 * FlashData Accessor Method
	 * FlashData is readable persistence
	 * data that gets deleted once it is
	 * read.
	 */

	public function __get($key) {
		if(!isset($_SESSION["flashdata_" . $key])) {
			return null;
		}
		$value = $_SESSION["flashdata_" . $key];
		unset($_SESSION["flashdata_" . $key]);
		return $value;
	}
	
	/**
	 * FlashData mutator method
	 * Sets a flash Data value
	 */
	
	public function __set($key, $value) {
		$_SESSION["flashdata_" . $key] = $value;
	}

}