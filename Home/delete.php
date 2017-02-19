<?php 
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';

if(!$_SESSION['emailAddress']) {
	header("location: ../Login/index.php");

} else {
	$mysql = connectBlog();
	$postId = $_GET['postId'];
	mysqli_query($mysql, "DELETE FROM forum WHERE post_id = '$postId'");
	header("location: index.php");

}
?>