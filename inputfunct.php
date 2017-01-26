<?php
//Work on better names. Comments added

//Cleans input from malicious code.
function cleanInput($data) //move to objects folder
{
    $data = implode("", explode("\\", $data));
	$date = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
//Checks the strings for letters only.
function validateUserString($userString, $stringLength)
{
	$userString = cleanInput($userString);

	if (empty($userString)) {
		return $userString = "";
	}
    if (strlen($userString) > $stringLength) {
	    return $userString = "";
	}
	if (!preg_match("/^[a-zA-Z ]*$/", $userString)) {
		return $userSting = "";
	}
	return $userString;
}
//Temporary solution for date. ***REVISIT***
function validateUserInt($userInt, $intMin, $intMax)
{
	$userInt = cleanInput($userInt);

	if (empty($userInt)) {
		return $userInt = "";
	}
	if ($userInt < $intMin || $userInt > $intMax) {
	    return $userInt = "";
	}
	if (!filter_var($userInt, FILTER_VALIDATE_INT)) {
		return $userInt = "";
	}
	return $userInt;
}
//Check user clean and check user email.
function validateUserEmail($userEmail) 
{
	$userEmail = cleanInput($userEmail);

	if (empty($userEmail)) {
		return $userEmail = "";
	}
	if ($userEmail > 254) {
		return $userEmail = "";
	}
	if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
		return $userEmail = "";
	}
	return $userEmail;
}
//Clean password input and hash for database.
function hashUserPassword($userPassword) // move to a user folder
{
	if (strlen($userPassword) < 8 || strlen($userPassword) > 32) {
		return $userPassword = "";
	}
	$userPassword = cleanInput($userPassword);
	$hash = password_hash($userPassword, PASSWORD_DEFAULT);
	return $hash;
}
//Check all input variables, if false report where.
/*function arrayErrors($arrayErr) {
	foreach ($arrayErr as $keyErr => $valueErr) {
		if (empyt($valueErr)) {
			return ${'$keyErr' . "Err"} = "$keyErr" . "is required.";
		}	
	}
}*/
//Check all input variables if true.
function arrayAllTrue($array) 
{
	foreach ($array as $key => $value) {
		if (empty($value)) {
			echo "fail ";
			break;
		}
	}
}
function connectBlog() //move to a user folder
{
	//mysqli connection to database called blog_db
	$mysqli = new mysqli('localhost', 'root', '', 'blog_db');

	if ($mysqli->connect_error) {
		die('Connect Error (' . $myslqi->connect_errno . ') ' . $mysqli->connect_error);
	}
	return $mysqli;
}
?>
