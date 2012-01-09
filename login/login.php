<html>

	<head>
	<title>Login</title>

	</head>
	<body>
	
	<?php

 	$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

	//query string 	
 	$query = "select *";
   	$query .= " from users ";
	$query .= "where username = '";
	$query .= $_POST["username"];
	$query .= "' "; 
   	$query .= "and ";
	$query .= "password = '";		
	$query .= $_POST["password"];
	$query .= "';";      	

	//get db restult
	$dbResult = pg_query($query);

	//check for db error
   	if (!$dbResult)
 	{
     		die("Database error...");
   	}

	//get numer of rows
   	$num = pg_num_rows($dbResult);

	// if there is a row then the username and password pair exists
	if ($num > 0)
	{
		session_start();
	  	$_SESSION["Login"] = "YES";
          	header("Location: ../math/counting/count.php");
	}
	else
	{
	  	session_start();
	  	$_SESSION ["Login"] = "NO";
		header("Location: form.php");
	}

	?>

	</body>
	</html>

