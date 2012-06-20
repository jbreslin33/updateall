<?php include("../database/db_connect.php"); ?>

<?php

        //start new session     
        session_start();
	
	//set username and password
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["password"] = $_POST["password"];


	$usernameString = $_SESSION["username"];

	$noNumbers = true;

        $wordCount = str_word_count($usernameString);

	if ($wordCount != 1)
	{
		if ($wordCount == 0)
		{
        		header("Location: ../signup/signup_noname.php");
		}
		if ($wordCount > 1)
		{
        		header("Location: ../signup/signup_nospace.php");
		}
	}


	else
	{
		//check for no numbers
		//let's first convert to arrray
		$stringArray = str_split($usernameString);	

		$arraySize = count($stringArray);
		for ($i=0; $i < $arraySize; $i++)
		{
			if ($stringArray[$i] == '2')
			{
				$noNumbers = false;
			}

		}

		if ($noNumbers == false)
		{
        		header("Location: ../signup/signup_nonumbers.php");
		}

		else	
		{

			//db connection
			$conn = dbConnect();
	
			//query string 	
			$query = "INSERT INTO users(username, password, role, admin, teacher) VALUES ('";
			$query .= $_SESSION["username"];
			$query .= "','"; 
			$query .= $_SESSION["password"];
			$query .= "','Admin',"; 
			$query .= "'"; 
			$query .= $_SESSION["username"];
			$query .= "','"; 
			$query .= $_SESSION["username"];
			$query .= "'"; 
			$query .= ");";      	

			// insert into users......
			$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());


			//ok let's act like we are logging in.....
			//query string  
        		$query = "select math_level, english_level, role from users where username = '";
        		$query .= $_SESSION["username"];
        		$query .= "' "; 
        		$query .= "and ";
        		$query .= "password = '";               
        		$query .= $_SESSION["password"];
        		$query .= "';";         

        		//get db result
        		$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

        		//get numer of rows
        		$num = pg_num_rows($result);
        
        		//close db connection as we have the only var we needed - the id
        		pg_close();
       

			// if there is a row then the username and password pair exists
        		if ($num > 0)
        		{
                		//get the id from user table    
                		$mathLevel = pg_Result($result, 0, 'math_level');
                		$englishLevel = pg_Result($result, 0, 'english_level');
                		$roleId = pg_Result($result, 0, 'role');
                
                		//set login var to yes  
                		$_SESSION["Login"] = "YES";
          
                		//set user and subject levels to be used later                      
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
		}
	}
?>

