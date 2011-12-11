<?php

namespace Atomic\Views;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

abstract class Model {

	protected static $_instances = array();

	/**
	 * Creates a new Model Instance and
	 * keeps a record of its instance
	 * @return Model Object
	 */
	
	public static function getInstance() {
		$class = get_called_class();
		if(! isset(static::$_instances[$class])) {
			static::$_instances[$class] = new $class();
		}
		return static::$_instances[$class];
	}
}