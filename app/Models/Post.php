<?php

namespace App\Models;

/*
 *	Created for AtomicPHP Framework
 *	Copyright 2011 Shane Perreault All Rights Reserved
 */
 
use Atomic\Config\Config;
use Atomic\Database\DatabaseFactory;
use Atomic\Models\Model;

class Post extends Model {

	public function getPost($id) {
		$db = DatabaseFactory::factory();
		$query = "SELECT * FROM `posts` WHERE `id` = ?";
		$statement = $db->prepare($query);
		$statement->execute(array($id));
		$post = $statement->fetchObject();
		return $post;
	}
}