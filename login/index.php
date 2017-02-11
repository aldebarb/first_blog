<!DOCTYPE html>
<html>
<head>
	<title>Blog Login</title>
<!--
//remove malicious code
//connect to blog_db
//check if emailAddress exists
//check if password exists
//redirect to the blog page
-->

</head>
<body>
<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';
$emailAddress = $password = $mysql = $query = "";
$tablesEmailAddress = $tablesPasswordHash = $verifyPassword = "";

if(isset($_POST['submit'])) {
    $emailAddress = removeMaliciousCode($_POST['emailAddress']);
    $password = removeMaliciousCode($_POST['password']);
    $passwordHash = hashUserPassword($password);
    $mysql = connectBlog();
    $query = mysqli_query($mysql, "SELECT * FROM user_login WHERE email_address = '$emailAddress'");
    	
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $tablesEmailAddress = $row['email_address'];
        $tablesPasswordHash = $row['password_hash'];
        $verifyPassword = password_verify($password, $tablesPasswordHash);

		if(($tablesEmailAddress == $emailAddress) && ($verifyPassword == true)) {
		    $_SESSION['emailAddress'] = $emailAddress;
		    header("location: ../Home/index.php");
		    
		} else {
    		print '<script>alert("Invalid Email or Password!");</script>';
			print '<script>window.location.assign("index.php");</script>';    	
        }
    }
}

?>
<h2>Weclome to Char120 the personal blog!</h2>
<p>Here you can share your own blog and comment on others.</p>

<form method="post" action="">
	<label>Enter your login information.</label><br>
	Username: <input type="text" name="emailAddress"><br>
	Password: <input type="password" name="password">
	<input type="submit" name="submit" value="Login">
</form><br>

<p>Don't have an account? <a href="register.php">Click here and join today!</a></p>
<p>Check out the blog. <a href="/Home/index.php">Visit as a guest.</a>

</body>
</html>