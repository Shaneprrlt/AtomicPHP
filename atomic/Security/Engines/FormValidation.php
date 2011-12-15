<?php

namespace Atomic\Security\Engines;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Security\Validation;
 
public class FormValidation extends Validation {

	protected $_auth_token;
	protected $_auth_expiration_time;

	/**
	 * FormValidation class Constructor
	 */

	public function __construct() {
		$this->_auth_token
			 = $this->generateToken();
		$this->_auth_expiration_time
			 = $this->generateExpirationTime();
	}
	
	/**
	 * FormValidation class Destructor
	 */
	
	public function __destruct() {
		$this->destroy();
	}
	
	/**
	 * Destroys session data that conatins
	 * authentication information.
	 */
	
	public function destroy() {
		unset($_SESSION["_auth_token"]);
		unset($_SESSION["_auth_expiration_time"]);
	}
	
	/**
	 * Generates a new Form Authentication Token.
	 * @return a string randomly generated
	 */
	
	public function generateToken() {
		$str = md5(str_shuffle(
			rand() . microtime()));
		$_SESSION["_auth_token"] = $str;
		return $str;
	}
	
	/**
	 * Sets an expiration time 30 minutes in
	 * later after token generation.
	 * @return timestamp 30 minutes into future
	 */
	
	public function generateExpirationTime() {
		$expiration_time = microtime()
			+ (30 * 60 * 1000);
		$_SESSION["_auth_expiration_time"]
			= $expiration_time;
		return $expiration_time;
	}
	
	/**
	 * Returns the current active AuthToken
	 */
	
	public function getAuthToken() {
		return $this->_auth_token;
	}
	
	/**
	 * Returns the current AuthToken Expiration Time
	 */
	
	public function getExpirationTime() {
		return $this->_auth_expiration_time;
	}
}