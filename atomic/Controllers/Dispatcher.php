<?php

namespace Atomic\Controllers;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;
use Atomic\Controllers\Exceptions\MethodNotValidException;
use Atomic\Controllers\Exceptions\MissingClassException;
use Atomic\Controllers\Exceptions\PassRequestException;
use Atomic\Controllers\Exceptions\RequestMethodNotFoundException;
use Atomic\Controllers\Exceptions\UriNotProcessableException;

class Dispatcher {
	const GET = "get";
	const POST = "post";
	protected static $_routes = array();
	
	/**
	 * Adds a new route rule to the rule
	 * stack, this is how you specify different
	 * paths in your application.
	 * @param $alias The Resource Alias
	 * @param $info The configuration for the request
	 */
	
	public static function addRule($alias, $info) {
		if($alias && (gettype($info) == "array")) {
			static::$_routes[] = array(
				"regex"      => static::convertToRegex($alias),
				"alias"      => $alias,
				"controller" => $info["controller"],
				"function"   => $info["function"],
				"method"     => $info["method"]
			);
		}
	}
	
	/**
	 * This initializes the dispatcher
	 * and passes requests from the browser
	 * into class/method loaders.
	 */
	
	public static function init() {
		$request_uri = static::getRequestResource();
		$request_method = static::getRequestMethod();
		foreach(static::$_routes as $route) {
			if($route["method"] == strtolower($request_method)) {
				if(preg_match($route["regex"], $request_uri)) {
					$alias_pieces = explode("/", substr($route["alias"], 1));
					$request_uri_pieces = explode("/", substr($request_uri, 1));
					for($i = 0; $i < count($request_uri_pieces); $i++) {
						if(strpos($alias_pieces[$i], ":") === 0) {
							$parameters[substr($alias_pieces[$i], 1)]
								= $request_url_pieces[$i];
						}
						if($request_method === Dispatcher::POST) {
							$parameters = array_merge($parameters, $_POST);
						}
						static::passRequest($route["controller"], $route["function"],
							$parameters);
					}
				}
			}
		}
	}
	
	/**
	 * Gets the URI that the sent by the Client.
	 * @return string The URI the page was requested with
	 */
	
	public static function getRequestResource() {
		if(isset($_SERVER["PATH_INFO"])) {
			return $_SERVER["PATH_INFO"];
		}
		else if(isset($_SERVER["PHP_SELF"])) {
			return $_SERVER["PHP_SELF"];
		}
		else if(isset($_SERVER["REQUEST_URI"])) {
			$uri = $_SERVER["REQUEST_URI"];
			if($request_uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)) {
				$uri = $request_uri;
			}
			return rawurldecode($uri);	
		}
		else {
			throw new UriNotProcessableException(
				"Could not find the request URI using PATH_INFO, PHP_SELF, or REQUEST_URI.");
		}
	}
	
	/**
	 * Gets the HTTP Method used to access the page.
	 * @return string The HTTP method used to access the page
	 */
	
	public static function getRequestMethod() {
		if(isset($_SERVER["REQUEST_METHOD"])) {
			return $_SERVER["REQUEST_METHOD"];
		}
		else {
			throw new RequestMethodNotFoundException(
				"Could not find the Request Method");
		}
	}
	
	/**
	 * Converts a developer-inputed route alias
	 * and converts it to a valid regular expression.
	 * @param $str The Alias of the resource
	 * @return string a valid regular expression
	 */
	
	public static function convertToRegex($str) {
		$regex = "`";
		if($str[0] == "/") {
			$str = substr($str, 1);
		}
		$alias_segments = explode("/", $str);
		foreach($alias_segments as $expression) {
			if(strpos($expression, ":") === 0) {
				$regex .= "/[a-zA-Z0-9]+";
			}
			else {
				$regex .= "/{$expression}";
			}
		}
		return $regex . "`";
	}
	
	/**
	 * Passes the request by loading the controller, executing
	 * the function requested and passing any required parameters.
	 * @param $controller The Requested Controller
	 * @param $function The requested function
	 * @param $args The Parameters of the function
	 * @param $namespace Controller namespace, defaults if not specified
	 */
	
	public static function passRequest($controller, $function,
		$args = false, $namespace = false) {
		if($namespace === false) {
			$namespace = Config::getRequiredVal("app",
				"controller_namespace");
		}
		$class = $namespace . $controller;
		if(@class_exists($class)) {
		
			$obj = $class::getInstance();
			$obj->setParameters($parameters);
			try {
				call_user_func_array(
					array($obj, $function), array());
			}
			catch(PassRequestException $e) {
				throw new PassRequestException(
					$e->getMessage());
			}
		}
		else {
			throw new MissingClassException(
				"Could not find controller {$controller}");
		}
	}
}