<?php

function removeMaliciousCode($data)
{
    $data = implode("", explode("\\", $data));
	$date = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function checkStringLength($userString, $stringLength)
{
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
//fix this***
function validateUserInt($userInt, $intMin, $intMax)
{
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
function verifyEmail($userEmail) 
{
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
?>
