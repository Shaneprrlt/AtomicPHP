<?php

namespace Atomic\Views;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */

use Atomic\Config\Config;
use Atomic\Views\Sandbox;
use Atomic\Views\Exceptions\DirNotWriteableException;
use Atomic\Views\Exceptions\FileNotFoundException;
use Atomic\Views\Exceptions\FileNotWriteableException;

class Views {

	protected static $_components = array();
	protected static $_default_extension = '.html.php';
	protected static $_default_replace_key = '%{{YIELD}}%';

	/*	Adds Block Elements to be added to the
	 *	final rendered page.
	 *
	 *	@params $_replace_key The Replace Key to Look For in View Template
	 *	@params $_view The name of the view file located in the /layout dir
	 */

	public static function addComponent($_replace_key, $_view) {
		// Find Path to View File
		$_file_path = Config::getBasePath() . "/app/Views/layout/"
			. $_view . static::$_default_extension;
		
		// Load View File using file_get_contents
		$_file_contents = file_get_contents($_file_path);
		
		// Add to Component Array
		static::$_components[$_replace_key] = $_file_contents;
	}

	/*	Loads the View File into the Web Browser
	 *	and passes data to it through associative array
	 *
	 *	@params $controller The Controller Directory Name
	 *	@params $view The View File Requested
	 *	@params $data The Associative Array filled with Page Data
	 *	@throws DirNotWriteableException
	 *	@throws FileNotFoundException
	 *	@throws FileNotWriteableException
	 */

	public static function load($controller, $view, $data = array()) {
		// Find Path to Layout File
		$_layout_path = Config::getBasePath() . "/app/Views/layouts/"
			. "application" . static::$_default_extension;
			
		// Find Path to View File
		$_view_path = Config::getBasePath() . "/app/Views/"
			. $controller . "/" . $view . static::$_default_extension;
			
		// Get Contents of Layout File using file_get_contents
		$_layout_contents = file_get_contents($_layout_path);
		
		// Get Contents of View File using file_get_contents
		$_view_contents = file_get_contents($_view_path);
		
		// Merge Layout File and View File
		$_tmp_content = str_replace(static::$_default_replace_key,
			$_view_contents, $_layout_contents);
			
		// Add Components to View
		foreach(static::$_components as $_replace_key => $_content) {
			$_tmp_content = str_replace($_replace_key, $_content, $_tmp_content);
		}
		
		// Create New Temporary File Path
		$_tmp_path = Config::getBasePath() . "/tmp/" . microtime(true) . ".php";
		
		// Write the New File
		file_put_contents($_tmp_path, $_tmp_content);
		
		// Extract Data
		extract($data);
		
		// Include File
		include($_tmp_path);
		
		// Delete Temporary File
		unlink($_tmp_path);
		
		// Empty out Components
		static::$_components = array();
	}
}