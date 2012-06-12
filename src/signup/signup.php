<?php include("../database/db_connect.php"); ?>

<?php

	//set username and password
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["password"] = $_POST["password"];

	//db connection
	$conn = dbConnect();
	
	//query string 	
	$query = "INSERT INTO users(username, password, role_id) VALUES ('";
	$query .= $_SESSION["username"];
	$query .= "', '"; 
	$query .= $_SESSION["password"];
	$query .= "',2"; 
	$query .= ");";      	

	// insert into users......
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

	//then send to login_form.php to login, later send message.... actually it's later now and you need to take them directly to site.

	header("Location: ../login/login_form.php");


?>

