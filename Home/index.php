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
    //forum (post_id, user_id, post_title, post_blog, post_date, post_time)
    //users (user_id, first_name, last_name, birth_date)
    //user_login(login_id, user_id, email_address, password_hash)
//
-->
</head>
<body>
<form method="get" action="add.php">
    <h2>Make a new post?</h2>
    <input type="submit" name="addPost" value="Add Post">
    <a href="../Login/logout.php">Click here to logout.</a>
</form>    

<?php
$userId = $blogPost = $time = $date = "";

if (!$_SESSION['emailAddress']) {
	header("location: ../Login/index.php");

} else {
	$mysql = connectBlog();
	$query = mysqli_query($mysql, "SELECT forum.post_title, user_login.email_address, forum.post_date, forum.post_time, forum.post_blog, forum.post_id FROM forum JOIN user_login ON forum.user_id = user_login.user_id ORDER BY forum.post_id DESC");

	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        print '<div>';
            print '<h1>'. $row['post_title'] . '</h1>';
            print '<p>' . $row['post_blog'] . '</p>';
            print '<p>Posted on ' . $row['post_date'] . " - " . $row['post_time'] . '</p>';
            print '<p>Posted by: ' . $row['email_address'] . '</p>';
        print '</div>';
      
        print '<form method="post" action="delete.php?postId=' . $row['post_id'] . '">';
        print '<input type="submit" name="delete" value="Delete">';
        print '<a href="edit.php?postId=' . $row['post_id'] . '">Edit Post?</a>';
        print '</form>';
	}
}
?>
</body>
</html>