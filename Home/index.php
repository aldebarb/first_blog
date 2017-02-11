<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
<!--
//Connect to blog_db
//SELECT forum table + Display forum
//Schema
//forum (post_id, user_id, post)
//comment(comment_id, post_id, user_id, comment
-->
</head>
<body>

<?php
session_start();
if($_SESSION['emailAddress']) {
	echo "Congrats! You are logged in as " . $_SESSION['emailAddress'];
}
?>

<form>
	<textarea name="comment" rows="3" cols="40"></textarea>
	<input type="submit" name="submit" value="Post">
</form>
</body>
</html>