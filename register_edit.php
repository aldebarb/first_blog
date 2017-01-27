
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
<?php 
require 'inputfunct.php';
?>
<style>
	.error {color: #FF0000;}
</style>
</head>
<body>
<?php
$fName = $lName = $email = "";
$fNameErr = $lNameErr = $emailErr = $passwordErr = "";
$arrayBool = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST['fName'])) {
        $fNameErr = "First name is required.";
    } else {
    	$fName = removeMaliciousCode($_POST['fName']);
    	//Check for letters and length
    	$fName = checkStringLength($fName, 32);
    	if(empty($fName)) {
    		$fNameErr = "Letters only.";
    	}
    }
    if(empty($_POST['lName'])) {
    	$lNameErr = "Last name is required.";
    } else {
    	$fName = removeMaliciousCode($_POST['lName']);
    	$lName = checkStringLength($lName, 32);
        if(empty($lName)) {
        	$lNameErr = "Letters only.";
        }
    }
    if(empty($_POST['email'])) {
    	$emailErr = "Email required.";
    } else {
    	$email = removeMaliciousCode($_POST['email']);
    	$email = validateEmail($email);
    	if(empty($email)) {
    		$emailErr = "Invalid email address.";
    	}
    }
    if(empty($_POST['password'])) {
    	$passwordErr = 'Password required.';
    } else {
    	$password = removeMaliciousCode($_POST['password']);
    	$password = hashUserPassword($_POST['password']);
    	if(empty($password)) {
    		$passwordErr = "Password must be between 8 and 32 characters.";
    	}
    }
}	
?>


<h2>Enter your information</h2><br>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name: <input type="text" name="fName" value="<?php echo $fName;?>">
    <span class="error">* <?php echo $fNameErr;?></span><br><br>
    Last Name: <input type="text" name="lName" value="<?php echo $lName;?>">
    <span class="error">* <?php echo $lNameErr;?></span><br><br>       
    Email: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span><br><br>
    Password: <input type="text" name="password">
    <span class="error">* <?php echo $passwordErr;?></span>
   
    <input type="submit" name="submit" value="Submit">
</form>

<?php
    //echo "$fName $lName $month $day $year $email $password";

?>


</body>
</html>