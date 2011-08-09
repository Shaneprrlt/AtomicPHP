<?php

namespace Core\System\Models;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

abstract class Model {

	/* Holds the Model Instances */
	
	protected static $_instances = array();
	
	/*	Returns the instance of the
	 *	requested Model.
	 *
	 *	@return object Model Object
	 */
	
	public static function getInstance() {
	
		$class_name = get_called_class();
	
		if(! static::$_instances[$class_name]) {
		
			static::$_instances[$class_name] = new $class_name();
		
		}
		
		return static::$_instances[$class_name];
	
	}

}