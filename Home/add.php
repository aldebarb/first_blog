
<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';

if(!$_SESSION['emailAddress']) {
    header("location: ../Login/index.php");

} else {
    
    if(isset($_POST['submit'])) {
        $userId = $_SESSION['userId'];
        $postTitle = removeMaliciousCode($_POST['postTitle']);
    	$postBlog = removeMaliciousCode($_POST['postBlog']);
        $time = strftime("%X");
        $date = strftime("%B %d, %Y");

        if((empty($postBlog)) || (empty($postTitle))) {
            echo "Not a valid post!";

        } else {
            $mysql = connectBlog();
            mysqli_query($mysql, "INSERT INTO forum (user_id, post_title, post_blog, post_date, post_time) VALUES ('$userId', '$postTitle', '$postBlog', '$date', '$time')");
            header("location: ../Home/index.php");
        }
    }
}
?>

<form method="post" action="">
	<h2>Title</h2><br>
    <input type="text" name="postTitle" maxlenght="32"> <br>
    <p>Post</p><br>
	<textarea name="postBlog" rows="3" cols="40" maxlength="120"></textarea>
	<input type="submit" name="submit" value="Post">
</form>