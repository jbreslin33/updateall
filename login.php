<html>

	<head>
	<title>Login</title>

	</head>
	<body>

<?php include("db_connect.php"); ?>

<?php

	//db connection
	$conn = dbConnect();
	
	//query string 	
 	$query = "select id";
   	$query .= " from users ";
	$query .= "where username = '";
	$query .= $_POST["username"];
	$query .= "' "; 
   	$query .= "and ";
	$query .= "password = '";		
	$query .= $_POST["password"];
	$query .= "';";      	

	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

	//get numer of rows
   	$num = pg_num_rows($result);
	
	//close db connection as we have the only var we needed - the id
	pg_close();
	
	//start new session	
	session_start();
	
	// if there is a row then the username and password pair exists
	if ($num > 0)
	{
		//get the id from user table	
		$id = pg_Result($result, 0, 'id');
		
		//set login var to yes	
	  	$_SESSION["Login"] = "YES";
          
		//set user id to be used later			
		$_SESSION["id"] = $id;  	

		//send user to his game_url		
		header("Location: game.php");
	}
	else
	{
		//set login cookie to no	
		$_SESSION ["Login"] = "NO";
		
		//send user back to login form
		header("Location: login_form.php");
	}
?>
	</body>
	</html>

