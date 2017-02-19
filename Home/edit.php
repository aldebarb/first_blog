<?php 
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';

if(!$_SESSION['emailAddress']) {
    header("location: ../Login/index.php");

} else {
    $mysql = connectBlog();
    $postId = $_GET['postId'];
    $query = mysqli_query($mysql, "SELECT post_title, post_blog FROM forum WHERE post_id = '$postId'");
   
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    	$postTitle = $row['post_title'];
    	$postBlog = $row['post_blog'];
    }
    
    if(isset($_POST['submit'])) {
        $userId = $_SESSION['userId'];
        $postTitle = removeMaliciousCode($_POST['postTitle']);
    	$postBlog = removeMaliciousCode($_POST['postBlog']);
        $time = strftime("%X");
        $date = strftime("%B %d, %Y");

        if((empty($postBlog)) || (empty($postTitle))) {
            echo "Not a valid post!";

        } else {
            $queryMe = mysqli_query($mysql, "UPDATE forum SET user_id = '$userId', post_title = '$postTitle', post_blog = '$postBlog', post_date = '$date', post_time = '$time' WHERE post_id = '$postId'");
            if($queryMe) {
            header("location: ../Home/index.php");
            } else {
                echo "Not Entered";
            }
        }
    }
}
?>

<form method="post" action="">
	<h2>Title</h2><br>
    <input type="text" name="postTitle" maxlenght="32" value="<?php echo $postTitle;?>"> <br>
    <p>Post</p><br>
	<textarea name="postBlog" rows="3" cols="40" maxlength="120"><?php echo $postBlog;?></textarea>
	<input type="submit" name="submit" value="Post">
</form>