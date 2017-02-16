<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
<!--
//Connect to blog_db
//SELECT forum table + Display forum
    //Schema
    //forum (post_id, user_id, post_title, blog_post, post_date, post_time)
    //comment(comment_id, post_id, user_id, comment, comment_date, comment_time)
    //users (user_id, first_name, last_name, birth_date)
    //user_login(login_id, user_id, email_address, password_hash)
//
-->
</head>
<body>
<?php

$userId = $blogPost = $time = $date = "";

if(!$_SESSION['emailAddress']) {
	header("location: ../Login/index.php");

} else {
    //echo "Congrats you are logged in as " . $_SESSION['emailAddress'] . " and your id# is " . $_SESSION['userId'];
	$mysql = connect_blog();
	$query = mysqli_query($mysql, "SELECT forum.post_title, user_login.email_address, forum.post_date, forum.post_time, forum.blog_post FROM forum JOIN user_login ON forum.user_id = user_login.user_id");

	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        echo '<div>';
            echo '<h1>'. $row['post_title'] . '</h1>';
            echo '<p>' . $row['blog_post'] . '</p>';
            echo '<p>Posted on ' . $row['']
	}

    if(isset($_POST['submit'])) {
        $userId = $_SESSION['userId'];
    	$blogPost = removeMaliciousCode($_POST['blog_post']);
        $blogPost = checkStringLength($blogPost);
        $time = strftime("%X");
        $date = strftime("%B %d, %Y");

        if(empty($blogPost)) {
            echo "Not a valid post!";

        } else {
            mysqli_query($mysql, "INSERT INTO forum (user_id, blog_post, post_date, post_time) VALUES ('$userId', '$blogPost', '$date', '$time')");
        }
    }
}
?>

<form>
	<h2>Make a post?</h2>
	<textarea name="blog_post" rows="3" cols="40" maxlength="120"></textarea>
	<input type="submit" name="submit" value="Post">
</form>
</body>
</html>