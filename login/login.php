<html>

	<head>
	<title>Login</title>

	</head>
	<body>
	
	<?php

 	$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");
	
 	$query = "select *";
   	$query .= " from users ";
	$query .= "where username = '";
	$query .= $_POST["username"];
	$query .= "' "; 
   	$query .= "and ";
	$query .= "password = '";		
	$query .= $_POST["password"];
	$query .= "';";      	

	$dbResult = pg_query($query);

   	if (!$dbResult)
 	{
     		die("Database error...");
   	}

   	$num = pg_num_rows($dbResult);
//	$username      = pg_Result ($dbResult, $i, 'username');

	// Check if username and password are correct
	if ($num > 0)
	{
	 
	// If correct, we set the session to YES
	  session_start();
	  $_SESSION["Login"] = "YES";
//	  echo "<h1>You are now logged correctly in</h1>";
//	  echo "<p><a href='../countTo10.php'>Link to protected file</a><p/>";

	}
	else
	{
		
	}



        // Start up your PHP Session
        session_start();

        // If the user is not logged in send him/her to the login form
        if ($_SESSION["Login"] == "YES") {
          header("Location: ../countTo10.php");
        }
		





	 
	}
	else {
	 
	// If not correct, we set the session to NO
	  session_start();
	  $_SESSION ["Login"] = "NO";
	  echo "<h1>You are NOT logged correctly in </ h1>";
	  echo "<p><a href='../countTo10.php'>Link to protected file</a></p>";
	 
	}

	?>

	</body>
	</html>

