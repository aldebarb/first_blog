<!DOCTYPE html>
<html>
<head>
	<title>Blog Login</title>

</head>
<body>
<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';
$emailAddress = $password = $passwordHash = "";
//remove malicious code
//connect to blog_db
//check if emailAddress exists
//check if password exists
//redirect to the blog page.
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $emailAddress = removeMaliciousCode($_POST['emailAddress']);
    $password = removeMaliciousCode($_POST['password']);
    $passwordHash = hashUserPassword($password);

    if(isset($_POST['login'])) {
    	$mysql = connectBlog();
    	$query = mysqli_query($mysql, "SELECT * FROM user_login");
    	while($row = mysqli_fetch_array($query)) {
            $tablesEmailAddress = $row['email_address'];
            $tablesPassword = $row['password_hash'];

    		if(($tablesEmailAddress == $emailAddress) &&($tablesPassword == $passwordHash)) {
    		    $_SESSION['emailAddress'] = $emailAddress;
    		    //header("location: /Home.index.php");
    		    echo "Congrats you are in the system";
    		} else {
    			print '<script>alert("Invalid Email or Password!");</script>';
    			print '<script>window.location.assign("index.php");</script>';
    		}
    	}
    }
}

?>
<h2>Weclome to the personal blog!</h2>
<p>Here you can share your own blog and comment on others.</p>


<form method="post" action="">
	<label>Enter your login information.</label><br>
	Username: <input type="text" name="email"><br>
	Password: <input type="text" name="password">
	<input type="submit" name="login" value="Login">
</form><br>

<p>Don't have an account? <a href="register.php">Click here and join today!</a></p>
<p>Check out the blog. <a href="/Home/index.php">Visit as a guest.</a>

</body>
</html>

