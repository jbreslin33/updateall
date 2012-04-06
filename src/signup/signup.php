<?php include("../database/db_connect.php"); ?>

<?php
	//db connection
	$conn = dbConnect();
	
	//query string 	
	$query = "INSERT INTO users(username, password) VALUES ('";
	$query .= $_POST["username"];
	$query .= "', '"; 
	$query .= $_POST["password"];
	$query .= "');";      	

	// insert into users......
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

	//then send to login_form.php to login, later send message....
	header("Location: ../login/login_form.php");
?>

