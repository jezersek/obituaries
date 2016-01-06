<?php 
session_start();
if(isset($_SESSION['user']) != "")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';

if(isset($_POST['register']))
{	
		// getting data via $_POST and stripping them of special characters
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$lastname = mysql_real_escape_string($_POST['lastname']);
	$address = mysql_real_escape_string($_POST['address']);
	$phone = mysql_real_escape_string($_POST['phone']);
	$email = mysql_real_escape_string($_POST['email']);
	$pass = md5(mysql_real_escape_string($_POST['pass']));
	
		// checking if all the data is valid
	if(empty($firstname)) {
		$err = 'Firstname cannot be empty!';
	}
	elseif(!ctype_alpha(str_replace(' ', '', $firstname))) {
		$err = 'Firstname can only contain letters!';
	}
	
	if(empty($lastname)) {
		$err = 'Lastname cannot be empty!';
	}
	elseif(!ctype_alpha(str_replace(' ', '', $lastname))) {
		$err = 'Lastname can only contain letters!';
	}
	
	if(empty($address)) {
		$err = 'Address cannot be empty!';
	}
	elseif(!ctype_alnum(str_replace(' ', '', $address))) {
		$err = 'Address can only contain letters and numbers!';
	}
	
	if(empty($phone)) {
		$err = 'Phone cannot be empty!';
	}
	elseif(!ctype_digit($phone)) {
		$err = 'Phone can only contain numbers!';
	}

	if(empty($email)) {
		$err = 'Email cannot be empty!';
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err = 'Email address is not valid';
	}
	
	if(empty($pass)) {
		$err = 'Password cannot be empty!';
	}
	if(!empty($err)) {
		die($err);
	}
	
		// putting data into database
	if(mysql_query("INSERT INTO customers(name, lastname, address, phone, email,password) 
		VALUES('$firstname','$lastname','$address','$phone','$email','$pass')")) {
			?><script>alert('Successfully registered ');</script><?php
		}
	 else
	{
	?><script>alert('Registration was unsuccesfull');</script><?php
	}
 }

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="latin2_general_ci">
<title>User registration form</title>
</head>

<body>
<h1>User registration</h1>
<form method="post" accept-charset="latin2_general_ci" >
	First name: <input type="text" name="firstname" maxlength="25"><br />
	Last name: <input type="text" name="lastname" maxlength="35"><br />
	Address: <input type="text" name="address" maxlength="50"><br />
	Phone number: <input type="text" name="phone" maxlength="15"><br />
	Email address<input type="text" name="email" maxlength="30"><br />
	Password: <input type="password" name="pass1"><br />
	<input type="submit" name="register" value="Register">
</form>
</body>
</html>