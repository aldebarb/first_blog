<?php
function hashUserPassword($userPassword) 
{
	if (strlen($userPassword) < 8 || strlen($userPassword) > 32) {
		return $userPassword = "";
	}
	$hash = password_hash($userPassword, PASSWORD_DEFAULT);
	return $hash;
}
function connectBlog() 
{   //need to create database.
	//mysqli connection to database called blog_db
	$mysqli = new mysqli('localhost', 'root', '', 'blog_db');

	if ($mysqli->connect_error) {
		die('Connect Error (' . $myslqi->connect_errno . ') ' . $mysqli->connect_error);
	}
	return $mysqli;
}
?>