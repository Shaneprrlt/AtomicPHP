<?php

namespace App\Controllers;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Atomic\Controllers\Controller;
use Atomic\Views\Views;
use Atomic\Utilities\FlashData;
use App\Models\Post;

class Welcome extends Controller {

	/**
	 * First Install Welcome Page
	 */
	 
	public function main() {
		Views::load("welcome", "index");
	}
}