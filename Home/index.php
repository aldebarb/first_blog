<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
<!--
//Connect to blog_db
//SELECT forum table + Display forum
    //Schema
    //forum (post_id, user_id, blog_post, post_date, post_time)
    //comment(comment_id, post_id, user_id, comment, comment_date, comment_time)
    //users (user_id, first_name, last_name, birth_date)
    //user_login(login_id, user_id, email_address, password_hash)
//
-->
<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';
?>
</head>
<body>
<table border="1px" width="75%">
  <tr>
    <th>User</th>
    <th>Post Time</th>
    <th></th>
  </tr>
<?php
session_start();
$userId = $blogPost = $time = $date = "";
if(!$_SESSION['emailAddress']) {
	header("location: ../Login/index.php");

} else {
    //echo "Congrats you are logged in as " . $_SESSION['emailAddress'] . " and your id# is " . $_SESSION['userId'];
	$mysql = connect_blog();
	$query = mysqli_query($mysql, "SELECT user_login.email_address, forum.post_date, forum.post_time, forum.blog_post FROM forum JOIN user_login ON forum.user_id = user_login.user_id");

	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        print "<tr>";
        print '<td align="left">' . $row['email_address'] . "</td>";
        print '<td align="left">' . $row['date_posted'] . " - " . $row['time_posted'] . "</td>";
        print '<td align="center">' . $row['blog_post'] . "</td>"; 
        print "</tr>";
	}
    print "</table>";

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