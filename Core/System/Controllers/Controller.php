<?php

namespace Core\System\Controllers;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

abstract class Controller {

	/* Holds Controller Instances */
	
	protected static $_instances = array();
	
	/*	Retrieves the instance of the
	 *	called Controller.
	 *
	 *	This method should only be
	 *	called by the Dispatcher
	 *
	 *	@return object Controller
	 */

	public static function getInstance() {
	
		$class_name = get_called_class();
		
		if(! static::$_instances[$class_name]) {
			
			static::$_instances[$class_name] = new $class_name();
		}
		
		return static::$_instances[$class_name];
	}

}