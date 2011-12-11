<?php

namespace Atomic\Database;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

abstract class DatabaseEngine {

	/* Holds Database Engine Instance */

	protected static $_instance;

	/*	Retreives an Instance of the Database
	 *	engine called.
	 *
	 *	@returns object PDO Object
	 *	@throws ConnectionFailureException
	 */

	abstract public static function getInstance();

}