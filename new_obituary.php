<?php 
session_start();
if(isset($_SESSION['user']) != "")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';

if(isset($_POST['post']))
{	
		// getting data via $_POST and stripping them of special characters
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$lastname = mysql_real_escape_string($_POST['lastname']);
	$dateOfBirth = mysql_real_escape_string($_POST['dateOfBirth']);
	$dateOfDeath = mysql_real_escape_string($_POST['dateOfDeath']);
	$religion = mysql_real_escape_string($_POST['religion']);
	$location = mysql_real_escape_string($_POST['location']);
	$text = mysql_real_escape_string($_POST['text']);
	$size = mysql_real_escape_string($_POST['size']);
	
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
	
	if(empty($religion)) {
		$err = 'Please choose religion!';
	}
	
	if(empty($location)) {
		$err = 'Location cannot be empty!';
	}
	elseif(!ctype_alnum(str_replace(' ', '', $location))) {
		$err = 'Location can only contain numbers and letters!';
	}
	
	if(empty($text)) {
		$err = 'Text cannot be empty!';
	}
	elseif(!ctype_alnum(str_replace(' ', '', $text))) {
		$err = 'Text can only contain numbers and letters!';
	}
	// 
	print(exif_imagetype($_FILES['photo']['tmp_name']));
	if(!empty($_FILES["photo"]["name"])) {
		if(($_FILES['photo']['size'] < 1024000 ) && getimagesize($_FILES['photo']['tmp_name'])) {
			$photo_tmp = addslashes(file_get_contents($_FILES['photo']['tmp_name']));	
		}
		else {
			$err = 'This format of photo is unsupported or the photo is too big!';
		}
	}
	else {
		$photo_tmp = 0;
	}

	if(!empty($err)) {
		die($err);
	}
	
	$datePublished = date("Y-m-d");
	
		// putting data into database
	if(mysql_query("INSERT INTO obituaries(name, lastname, dateOfBirth, dateOfDeath, religion, location, text, image, size, datePublished) 
		VALUES('$firstname','$lastname','$dateOfBirth','$dateOfDeath','$religion','$location', '$text', '$photo_tmp', '$size', '$datePublished')")) {
			?><script>alert('Obituary was successfully posted ');</script><?php
		}
	 else
	{
	?><script>alert('Something went wrong');</script><?php
	}
 }

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="latin2_general_ci">
<title>Post a new obituary</title>
</head>

<body>
<h1>Post a new obituary</h1>
<form method="post" enctype="multipart/form-data" accept-charset="latin2_general_ci" >
	First name: <input type="text" name="firstname" maxlength="25"><br />
	Last name: <input type="text" name="lastname" maxlength="35"><br />
	Photo: <input type="hidden" name="MAX_FILE_SIZE" value="1024000" /><input type="file" name="photo"><br />
	Date of birth: <input type="date" name="dateOfBirth"><br />
	Date of death: <input type="date" name="dateOfDeath"><br />
	Religion: <br/>
		<input type="radio" name="religion" value="1">Catholic<br/>
		<input type="radio" name="religion" value="2">Orthodox<br/>
		<input type="radio" name="religion" value="3">Jewish<br/>
		<input type="radio" name="religion" value="4">Islam<br/>
		<input type="radio" name="religion" value="0">None<br/>
	Region/city: <input type="text" name="location" maxlength="50"><br />
	Text: <textarea name="text" maxlength="300"></textarea><br/>
	Choose size of obituary: <br/>
		<input type="radio" name="size" value="0" checked="true">Small<br/>
		<input type="radio" name="size" value="1">Medium<br/>
		<input type="radio" name="size" value="2">Large<br/>
	<input type="submit" name="post" value="Publish it">
</form>
</body>
</html>