<?php include("../database/db_connect.php"); ?>

<?php
	//db connection
	$conn = dbConnect();
	
	//query string 	
 	$query = "select math_level, english_level, role from users where username = '";
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
		$mathLevel = pg_Result($result, 0, 'math_level');
		$englishLevel = pg_Result($result, 0, 'english_level');
		$roleId = pg_Result($result, 0, 'role');
		
		//set login var to yes	
	  	$_SESSION["Login"] = "YES";
          
		//set user id, and subject levels to be used later			
		$_SESSION["username"] = $_POST["username"];  	
		$_SESSION["math_level"] = $mathLevel;  	
		$_SESSION["english_level"] = $englishLevel;  	
		$_SESSION["role"] = $roleId;  	
	

		//administrator
		if ($_SESSION["role"] == "Admin") 
		{
			header("Location: ../template/main/main.php");
		}
		
		//teacher
		if ($_SESSION["role"] == "Teacher") 
		{
			header("Location: ../template/main/main.php");
		}
		
		//student
		if ($_SESSION["role"] == "Student") 
		{
			header("Location: ../template/subject/chooser.php");
		}
		
		//guest
		if ($_SESSION["role"] == "Guest") 
		{
			header("Location: ../template/subject/chooser.php");
		}
	}
	else
	{
		//set login cookie to no	
		$_SESSION ["Login"] = "NO";
		
		//send user back to login form
		header("Location: login_form.php");
	}
?>

