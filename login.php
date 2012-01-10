<html>

	<head>
	<title>Login</title>

	</head>
	<body>
	
	<?php

	//user id
	$id = 0;
	$game_id = 0;
	$game_url = "";

	//db connection
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
	$dbResult_user = pg_query($query);

	//check for db error
   	if (!$dbResult_user)
 	{
     		die("Database error...");
   	}

	//get numer of rows
   	$num = pg_num_rows($dbResult_user);

	// if there is a row then the username and password pair exists
	if ($num > 0)
	{
		//game stuff
		$math_game_level = pg_Result ($dbResult_user, 0, 'math_game_level');

		//query string 	
 		$query = "select url ";
   		$query .= "from math_games ";
		$query .= "where level > ";
		$query .= $math_game_level;
		$query .= " ORDER BY level;"; 

		//get db restult
		$dbResult_game = pg_query($query);

		//check for db error
   		if (!$dbResult_game)
 		{
     			die("Database error...");
   		}

		//get user id and store it in session var
		$game_url = pg_Result ($dbResult_game, 0, 'url');

		//start new session	
		session_start();
		
		//set login var to yes	
	  	$_SESSION["Login"] = "YES";
          
		//set user id to be used later			
		$_SESSION["id"] = $id;  	
		
		//send user to his game_url		
		header("Location: $game_url");
	}
	else
	{
	  	//start new session	
		session_start();
	  	
		//set login cookie to no	
		$_SESSION ["Login"] = "NO";
		
		//send user to login as we don't care what level they are at until they login succesfully
		header("Location: login_form.php");
	}


pg_close();
	?>

	</body>
	</html>

