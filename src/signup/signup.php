<?php include("../database/db_connect.php"); ?>

<?php

        //start new session     
        session_start();
	
	//set username and password
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["password"] = $_POST["password"];


	$usernameString = $_SESSION["username"];


        $wordCount = str_word_count($usernameString);

	if ($wordCount > 1)
	{
        	header("Location: ../signup/signup_nospace.php");
	}

	else
	{

	//check for one word username	
/*
	$usernameArray = str_split(usernameString);
	$arraySize = count($usernameArray);
	
	for ($i=0; $i < $arraySize; $i++)
	{
		if ($usernameArray[$i] == '')
		{
                        header("Location: ../template/signup/signup_username_no_spaces.php");
		}
	}
*/

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


	//ok let's act like we are logging in.....
	//query string  
        $query = "select id, math_level, english_level, role_id from users where username = '";
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
       

// if there is a row then the username and password pair exists
        if ($num > 0)
        {
                //get the id from user table    
                $id = pg_Result($result, 0, 'id');
                $mathLevel = pg_Result($result, 0, 'math_level');
                $englishLevel = pg_Result($result, 0, 'english_level');
                $roleId = pg_Result($result, 0, 'role_id');
                
                //set login var to yes  
                $_SESSION["Login"] = "YES";
          
                //set user id, and subject levels to be used later                      
                $_SESSION["id"] = $id;          
                $_SESSION["username"] = $_POST["username"];     
                $_SESSION["math_level"] = $mathLevel;   
                $_SESSION["english_level"] = $englishLevel;     
                $_SESSION["role_id"] = $roleId;         
        

                //administrator
                if ($_SESSION["role_id"] == 1) 
                {
        
                }
                
                //teacher
                if ($_SESSION["role_id"] == 2) 
                {
                        header("Location: ../template/main/main.php");
                }
                
                //student
                if ($_SESSION["role_id"] == 3) 
                {
                        header("Location: ../template/choosers/chooser_subject.php");
                }
                
                //guest
                if ($_SESSION["role_id"] == 4) 
                {
        
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
?>

