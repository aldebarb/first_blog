
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
$firstName  = $lastName = $birthDate = $emailAddress = $password = $tempDate1 = $tempDate2 = "";
$firstNameErr = $lastNameErr = $birthDateErr = $emailAddressErr = $passwordErr = "";
$inputArray = array();

if (isset($_POST['submit'])) {
    
    if(empty($_POST['firstName'])) {
        $firstNameErr = "First name is required.";
        $inputArray['firstName'] = "";

    } else {
        $firstName  = removeMaliciousCode($_POST['firstName']);
    	//Check for letters and limit length
    	$firstName  = checkStringLength($firstName , 32);
        $inputArray['firstName'] = $firstName ;

    	if(empty($firstName )) {
    		$firstNameErr = "Letters only.";
    	}
    }
    if(empty($_POST['lastName'])) {
    	$lastNameErr = "Last name is required.";
        $inputArray['lastName'] = "";

    } else {
    	$lastName = removeMaliciousCode($_POST['lastName']);
    	$lastName = checkStringLength($lastName, 32);
        $inputArray['lastName'] = $lastName;

        if(empty($lastName)) {
        	$lastNameErr = "Letters only.";
        }
    }
    //Need to add date limits
    if(empty($_POST['birthDate'])) {
        $birthDateErr = "Birth date required.";
        $inputArray['birthDate'] = "";

    } else {
        $tempDate1 = removeMaliciousCode($_POST['birthDate']);
        $tempDate2 = strtotime($tempDate1);
        $birthDate = date('Y/m/d', $tempDate2);
        $inputArray['birthDate'] = $birthDate;
    }
    if(empty($_POST['emailAddress'])) {
    	$emailAddressErr = "Email address required.";
        $inputArray['emailAddress'] = "";

    } else {
    	$emailAddress = removeMaliciousCode($_POST['emailAddress']);
    	$emailAddress = verifyEmail($emailAddress);
        $inputArray['emailAddress'] = $emailAddress;

    	if(empty($emailAddress)) {
    		$emailAddressErr = "Invalid Email Address.";
    	}
    }
    if(empty($_POST['password'])) {
    	$passwordErr = 'Password required.';
        $inputArray['password'] = "";

    } else {
    	$password = removeMaliciousCode($_POST['password']);
    	$passwordHash = hashUserPassword($password);
        $inputArray['password'] = $password;
        $inputArray['passwordHash'] = $passwordHash;

    	if(empty($password)) {
    		$passwordErr = "Password must be between 8 and 32 characters.";
    	}
    }
    if(in_array("", $inputArray) || empty($inputArray)) {
        echo "Please fill in the entire form!";

    } else {
        //Connect to blog_db
        //Schema
        //users (user_id, first_name, last_name, birth_date)
        //user_login(login_id, user_id, email_address, password_hash)
        $mysql = connectBlog();
        $bool = true;
        $query = mysqli_query($mysql, "SELECT * FROM user_login");

        while($row = mysqli_fetch_array($query)) {
            $tablesEmailAddress = $row['email_address'];

            if($tablesEmailAddress == $emailAddress) {
                $bool = false;
                print '<script>alert("Email Address has been taken.");</script>';
                print '<script>window.location.assign("register.php");</script>';
            }
        }

        if($bool) {

            mysqli_query($mysql, "INSERT INTO users (first_name, last_name, birth_date) VALUES ('$firstName', '$lastName', '$birthDate')");
            //Retrieve the last inserted id.
            $user_id = mysqli_insert_id($mysql);
            //Insert into the user_login table. Is this a problem with multiple registrations at the same time? Is there a better way?
            mysqli_query($mysql, "INSERT INTO user_login (user_id, email_address, password_hash) VALUES ( '$user_id', '$emailAddress', '$passwordHash')");
            Print '<script>alert("Registration Complete!");</script>';
            Print '<script>window.location.assign("index.php");</script>';
        }
    }   
}
   /* //Test insert
    if(isset($_POST['test'])) {
        $mysqlTest = connectBlog();
        $queryTest1 = mysqli_query($mysqlTest, "INSERT INTO users (first_name, last_name, birth_date) VALUES ('firstTest', 'lastTest', '2001/01/01')");
        $user_id = mysqli_insert_id($mysqlTest);
        $queryTest2 = mysqli_query($mysqlTest, "INSERT INTO user_login (user_id, email_address, password_hash) VALUES ('$user_id', 'emailTest@yahoo.com', 'passwordTest')");
        if($queryTest1) {
            echo "Query1 Passed";
        }
        if($queryTest2) {
            echo "Query2 Passed";        
        }
    }*/	
?>

<h2>Enter your information</h2><br>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name: <input type="text" name="firstName" value="<?php echo $firstName ;?>">
    <span class="error">* <?php echo $firstNameErr;?></span><br><br>
    Last Name: <input type="text" name="lastName" value="<?php echo $lastName;?>">
    <span class="error">* <?php echo $lastNameErr;?></span><br><br>
    Birth Date: <input type="date" name="birthDate" value="<?php echo $tempDate1 ?>"> mm/dd/yyyy
    <span class="error">* <?php echo $birthDateErr;?></span><br><br>
    Email: <input type="text" name="emailAddress" value="<?php echo $emailAddress;?>">
    <span class="error">* <?php echo $emailAddressErr;?></span><br><br>
    Password: <input type="password" name="password">
    <span class="error">* <?php echo $passwordErr;?></span>
   
    <input type="submit" name="submit" value="Submit">
   <!-- <input type="submit" name="test" value="test"> -->
</form>

</body>
</html>