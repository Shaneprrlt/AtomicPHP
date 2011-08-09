<?php

namespace Core\System\Controllers;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Core\System\Config\Config;
use Core\System\Controllers\Exceptions\MissingClassException;
use Core\System\Controllers\Exceptions\PassRequestException;

class Dispatcher {

	/* Flags Dispatcher */

	protected static $_tmp_route;
	
	/* Holds Named Routes */

	protected static $_routes = array();
	
	/*	Sets the Default Page Load on
	 *	base domain request.
	 *
	 *	@params $source The Controller - Function Pair
	 */
	
	public static function setBaseRoute($source) {
	
		if(! static::$_routes['base_route']) {
			static::$_routes['base_route'] = explode('#', $source);
		}
	}
	
	/*	Adds a new Named Route to the
	 *	$_routes property.
	 *
	 *	@params $alias What the URI should look like
	 *	@params @source The Controller - Function Pair
	 */
	
	public static function addMatchedRoute($alias, $source) {
	
		if($alias[0] == '/') {
			$alias = substr($alias, 1);
		}
		
		static::$_routes[] = array($alias, explode('#', $source));
	}
	
	/*	Passes the Request by calling on the
	 *	controller the requested method with
	 *	additional arguements.
	 *
	 *	@params $controller The Requested Controller
	 *	@params $function The Requested Method to Load
	 *	@params $args optional The Parameters to pass to the method
	 *	@params $namespace optional The Namespace of the Controller
	 *	@throws MissingClassException
	 *	@throws PassRequestException
	 */
	
	public static function passRequest($controller, $function, $args = FALSE, $namespace = FALSE) {
	
		// Build Namespace
		if($namespace !=== FALSE) {
		
			if($namespace[0] == '\\') {
				$namespace = substr($namespace, 1);
			}
			
			if($namespace[strlen($namespace) - 1] !== '\\') {
				$namespace = $namespace . '\\';
			}
		}
		else {
			
			$namespace = 'App\Controllers\\';
		}
		
		// Build the Total Class Namespace Path
		$class_name = $namespace . ucfirst(strtolower($controller));
		
		if(@class_exists($class_name)) {
		
			// Instantiate Controller Object
			$object = $class_name::getInstance();
			
			try {
				
				// Perform Request
				call_user_func(array($object, $function), $args ?: array());
			}
			catch(PassRequestException $e) {
			
				throw new PassRequestException($e->getMessage());
			}
		
		}
		else {
		
			throw new MissingClassException("Could Not Find Requested Class");
		}
	}
	
	/*	Dispatches the Page Request to
	 *	proper channels
	 *
	 *	@return boolean True if Successful Dispatch
	 */
	
	public static function dispatch() {
	
		$url = Config::getVal('app', 'current_url');

		// If URL is Requesting Root
		if(empty($url) || $url == '')
		{
			// Get Data from Base Route
			$controller = self::$_routes['base_route'][0];
			$function = self::$_routes['base_route'][1];

			// Pass Request
			static::$_tmp_route = 1;
			static::passRequest($controller, $function);
			
			return true;
		}

		// Check for Route Matches
		if(! static::$_tmp_route)
		{ 

			// Temporary Route Count
			$tmp_route_count = array();

			// Shuffle Through Our Routes
			foreach(static::$_routes as $route)
			{

				$route_alias = $route[0];
				$route_src = $route[1];
				$regex = '';
				$args = array();

				// Split the Alias into Segements
				$route_alias_segements = explode('/', $route_alias);

				// Find the Placeholders
				foreach($route_alias_segements as $expression)
				{
					// Find Dynamic Expressions
					if(strpos($expression, ':') === 0) {
						$regex .= "\/[a-zA-Z0-9]+";
					} else {
						$regex .= "\/" . $expression;
					}
				}

				// Build Route Pattern Package
				$route_pattern[0] = $route_alias;
				$route_pattern[1] = $route_src;
				$route_pattern[2] = $regex;

				// Extends Tmp Route Count
				$tmp_route_count[] = $route_pattern;
			}

			// Shuffle Through our Formatted Routes
			foreach($tmp_route_count as $route)
			{
				// Match Regex to URL
				if(preg_match('/^' . $route[2] . '/', '/' . $url))
				{

					// Split URL Into Pieces
					$url_pieces = explode('/', $url);
					$route_length = count(explode('/', $route[0]));

					// If URL Pieces Count and Route Length are the Same
					if($route_length === (count($url_pieces)))
					{
						// Find Args from URL
						for($i=0; $i< count($url_pieces); $i++)
						{
							// Add Args to an Array
							if(strpos($route_alias_segements[0][$i], ':') === 0)
								$args[] = $url_pieces[$i];
						}

						// Get Data from Route
						$controller = $route_src[0];
						$function = $route_src[1];

						// Pass Request
						static::$_tmp_route = 1;
						static::passRequest($controller, $function, $args);
						
						return true;
					}

					// Break Foreach Loop
					break;
				}
			}

		}

		// Fallback to Default Route Scheme
		if(! static::$_tmp_route)
		{
			// Get Data from Route
			$route_src = explode('/', $url);
			$controller = $route_src[0];
			$function = $route_src[1];
			$args = array_slice($route_src, 2);

			// Pass Request
			static::passRequest($controller, $function, $args);
			
			return true;
		}
	}
}