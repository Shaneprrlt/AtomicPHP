<?php

namespace Atomic\Controllers;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

abstract class Controller {
	
	protected static $_instances = array();
	protected $parameters = array();
	
	/**
	 * Creates and gives a new Controller
	 * instance and keeps a record of it
	 * @return Controller Instance
	 */
	 
	public static function getInstance() {
		$class = get_called_class();
		if(! isset(static::$_instances[$class])) {
			static::$_instances[$class] = new $class();
		}
		return static::$_instances[$class];
	}
	
	/**
	 * Sets the parameters from the request.
	 * @param $parameters The Request Parameters
	 */
	
	public function setParameters($parameters) {
		$this->parameters = 
			array_merge($this->parameters, $parameters);
	}
}