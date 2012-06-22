<?php include("../database/db_connect.php"); ?>

<?php
	//db connection
	$conn = dbConnect();
	
	//----------------USER CHECK----------------------------------------------
	//query string 	
 	$query = "select id, first_name, last_name, school_id from users where username = '";
	$query .= $_POST["username"];
	$query .= "' "; 
   	$query .= "and ";
	$query .= "password = '";		
	$query .= $_POST["password"];
	$query .= "';";      	

	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

	//get numer of rows
   	$num = pg_num_rows($result);
	
	//start new session	
	session_start();
	
	// if there is a row then the username and password pair exists
	if ($num > 0)
	{
		//get the id from user table	
		$id = pg_Result($result, 0, 'id');
		$first_name = pg_Result($result, 0, 'first_name');
		$last_name = pg_Result($result, 0, 'last_name');
		$school_id = pg_Result($result, 0, 'school_id');
		
		//set login var to yes	
	  	$_SESSION["Login"] = "YES";
          
		//set user id, and subject levels to be used later			
		$_SESSION["username"] = $_POST["username"];  	
		$_SESSION["id"] = $id;  	
		$_SESSION["first_name"] = $first_name;  	
		$_SESSION["last_name"] = $last_name;  	
		$_SESSION["school_id"] = $school_id;  	

		//header("Location: ../template/main/main.php");
	}
	else
	{
		//set login cookie to no	
		$_SESSION ["Login"] = "NO";
		
		//send user back to login form
		header("Location: login_form.php");
	}

	//----------------SCHOOL CHECK----------------------------------------------
	//query string 	
 	$query = "select name from schools where id = ";
	$query .= $_SESSION["school_id"];
	$query .= ";";      	

	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

	//get numer of rows
   	$num = pg_num_rows($result);
	
	if ($num > 0)
	{
		//we are a school
		$_SESSION["is_school"] = "TRUE";  	
		
		//get the id from user table	
		$school_name = pg_Result($result, 0, 'name');
		
		//set user id, and subject levels to be used later			
		$_SESSION["school_name"] = $school_name;  	
	}
	else
	{
		//we are not a school
		$_SESSION["is_school"] = "FALSE";  	
		$_SESSION["school_name"] = "";  	
	}	
	
	//----------------STUDENT CHECK----------------------------------------------
	//is this user a student? if so let's set some session vars
	//query string 	
 	$query = "select math_level, english_level from students where id = ";
	$query .= $_SESSION["id"];
	$query .= ";";      	

	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

	//get numer of rows
   	$num = pg_num_rows($result);
	
	if ($num > 0)
	{
		//we are a student
		$_SESSION["is_student"] = "TRUE";  	
		
		//get the id from user table	
		$mathLevel = pg_Result($result, 0, 'math_level');
		$englishLevel = pg_Result($result, 0, 'english_level');
		
		//set user id, and subject levels to be used later			
		$_SESSION["math_level"] = $mathLevel;  	
		$_SESSION["english_level"] = $englishLevel;  	
	}
	else
	{
		//we are not a student
		$_SESSION["is_student"] = "FALSE";  	
		$_SESSION["math_level"] = "";  	
		$_SESSION["english_level"] = "";  	
	}	


	//-------------------ADMIN CHECK-------------------------------------------
	//is this user an admin ? if so let's set some session vars
	//query string 	
 	$query = "select id from admins where id = ";
	$query .= $_SESSION["id"];
	$query .= ";";      	

	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

	//get numer of rows
   	$num = pg_num_rows($result);

	if ($num > 0)
	{ 
		//we are an admin
		$_SESSION["is_admin"] = "TRUE";  	
	}
	else
	{
		//we are not an admin
		$_SESSION["is_admin"] = "FALSE";  	
	}	

	//----------------TEACHER CHECK----------------------------------------------
	//is this user a teacher ? if so let's set some session vars
	//query string 	
 	$query = "select id from teachers where id = ";
	$query .= $_SESSION["id"];
	$query .= ";";      	

	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

	//get numer of rows
   	$num = pg_num_rows($result);

	if ($num > 0)
	{ 
		//we are a teacher 
		$_SESSION["is_teacher"] = "TRUE";  	
	}
	else
	{
		//we are not a teacher 
		$_SESSION["is_teacher"] = "FALSE";  	
	}	
	
	//--------------------------------------------------------------
	header("Location: ../template/main/main.php");

	//close db connection as we have the only var we needed - the id
	pg_close();
?>

