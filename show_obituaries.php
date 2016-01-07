<?php 
session_start();

include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="latin2_general_ci">
<title>All obituaries</title>
</head>

<body>

<?php

if($_GET['id'] == '') {
	echo "<h1>All published obituaries</h1>";
	if($result = mysql_query("SELECT id, name, lastname, location, dateOfDeath FROM obituaries ORDER BY datePublished DESC")) {
		while($row = mysql_fetch_array($result)) {
			echo $row['name'] . " " . $row['lastname'] ." from " . $row['location'] . " died on " . $row['dateOfDeath'] . " <a href='?id=".$row['id']."'>Read more</a><br />";
		}
	}
	else {
		die('There was error while getting data from DB');
	}
}
else {
	$id = $_GET['id'];
	
	if($result = mysql_query("SELECT name, lastname, location, dateOfBirth, dateOfDeath, image, text FROM obituaries WHERE id=".$id)) {
		$row = mysql_fetch_array($result);
		echo "<h1>". $row['name'] . " " . $row['lastname'] . "</h1><h2>".$row['dateOfBirth']." - ". $row['dateOfDeath']."</h2>";
		if ($row['image']) {
			echo "<img src='data:image/jpeg;base64,".base64_encode($row['image']). "' width=200 /><br />";
		}
		echo "<p>".$row['text']."</p>";
	}
	else {
		die('This ID is not valid.');
	}
}
mysql_close();

?>
</body>
</html>