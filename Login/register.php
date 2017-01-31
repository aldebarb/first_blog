
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/GithubProjects/first_blog/Objects/formUtility.php';
require $_SERVER['DOCUMENT_ROOT'] . '/GitHubProjects/first_blog/User/index.php';
?>
<style>
	.error {color: #FF0000;}
</style>
</head>
<body>
<?php
$fName = $lName = $bDate = $birthDate = $email = $password = "";
$fNameErr = $lNameErr = $birthDateErr = $emailErr = $passwordErr = "";
$inputArray = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    if(empty($_POST['fName'])) {
        $fNameErr = "First name is required.";
        $inputArray['fName'] = "";
    } else {
        $fName = removeMaliciousCode($_POST['fName']);
    	//Check for letters and limit length
    	$fName = checkStringLength($fName, 32);
        $inputArray['fName'] = $fName;

    	if(empty($fName)) {
    		$fNameErr = "Letters only.";
    	}
    }
    if(empty($_POST['lName'])) {
    	$lNameErr = "Last name is required.";
        $inputArray['lName'] = "";
    } else {
    	$lName = removeMaliciousCode($_POST['lName']);
    	$lName = checkStringLength($lName, 32);
        $inputArray['lName'] = $lName;

        if(empty($lName)) {
        	$lNameErr = "Letters only.";
        }
    }
    //Need to add date limits
    if(empty($_POST['birthDate'])) {
        $birthDateErr = "Birth date required.";
        $inputArray['bDate'] = "";
    } else {
        $birthDate = strtotime($_POST['birthDate']);
        $bDate = date('m/d/Y', $birthDate);
        $inputArray['bDate'] = $bDate;
    }
    if(empty($_POST['email'])) {
    	$emailErr = "Email required.";
        $inputArray['email'] = "";

    } else {
    	$email = removeMaliciousCode($_POST['email']);
    	$email = verifyEmail($email);
        $inputArray['email'] = $email;

    	if(empty($email)) {
    		$emailErr = "Invalid email address.";
    	}
    }
    if(empty($_POST['password'])) {
    	$passwordErr = 'Password required.';
        $inputArray['password'] = "";
    } else {
    	$password = removeMaliciousCode($_POST['password']);
    	$passwordHash = hashUserPassword($password);
        $inputArray['password'] = $password;
        $inputArray['passwordhash'] = $passwordHash;
    	if(empty($password)) {
    		$passwordErr = "Password must be between 8 and 32 characters.";
    	}
    }
    if(isset($_POST['submit'])) {
        if(in_array("", $inputArray) || empty($inputArray)) {
            echo "Please fill in the entire form!";
        } else {
            $mysql = connectBlog();
            $bool = true;
            $query = mysqli_query($mysql, "SELECT * FROM users");

            while($row = mysqli_fetch_array($query)) {
                $table_users = $row['username'];

                if($username == $table_users) {
                    $bool = false;
                    print '<script>alert("Username has been taken.");</script>';
                    print '<script>window.location.assign("register.php");</script>';
                }
            }
            
            //Connect to DB
            //Check if email exists
            //Save to DB
            //Redirect to login
            header("location:check.php");

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
    Birth Date: <input type="date" name="birthDate" value="<?php echo $bDate ?>"> mm/dd/yyyy
    <span class="error">* <?php echo $birthDateErr;?></span><br><br>
    Email: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span><br><br>
    Password: <input type="text" name="password">
    <span class="error">* <?php echo $passwordErr;?></span>
   
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>