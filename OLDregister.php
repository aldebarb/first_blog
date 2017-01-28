
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
$FirstNameErr = $LastNameErr = $EmailErr = $PasswordErr = "";
$arrayBool = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//Validate all user input
	$fName = validateUserString($_POST['fName'], 32);
	$lName = validateUserString($_POST['lName'], 32);
	$month = validateUserInt($_POST['month'], 1, 12);
	$day = validateUserInt($_POST['day'], 1, 31);
	$year = validateUserInt($_POST['year'], 1900, 2016);
	$email = validateUserEmail($_POST['email']);
	$password = hashUserPassword($_POST['password']);
	$inputArray = array("fName"=>$fName, "lName"=>$lName, "month"=>$month, "day"=>$day, "year"=>$year, "email"=>$email, "password"=>$password);
	//Check and report any errors.
	//print_r($inputArray);
	
	$arrayBool = arrayAllTrue($inputArray);
	
	if ($arrayBool == true){
		echo "Finally it Works!";
		//$conn = connectBlog();
	}   
	//comments comments comments
}
?>


<h2>Enter your information</h2><br>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name: <input type="text" name="fName" value="<?php echo $fName;?>">
   <br><br>
    Last Name: <input type="text" name="lName" value="<?php echo $lName;?>">
   <br>
    Date of Birth: <input type="text" name="month" value="00">/<input type="text" name="day" value="00">/<input type="text" name="year" value="0000"><br><br>
   
    Email: <input type="text" name="email" value="<?php echo $email;?>"><br><br>
   
    Password: <input type="text" name="password">
   
    <input type="submit" name="submit" value="Submit">
</form>

<?php
    //echo "$fName $lName $month $day $year $email $password";

?>


</body>
</html>