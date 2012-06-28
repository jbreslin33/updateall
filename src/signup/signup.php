<?php include("../database/db_connect.php"); ?>

<?php

        //start new session     
        session_start();
	
	//set school_name, username and password
	$_SESSION["username"] = "root";
	$_SESSION["school_name"] = $_POST["schoolname"];
	$_SESSION["password"] = $_POST["password"];

	$schoolnameString = $_SESSION["school_name"];

	$number = false;
	$period = false;
	$space =  false;

	//check for no numbers
	//let's first convert to arrray
	$stringArray = str_split($schoolnameString);	

	$arraySize = count($stringArray);

	for ($i=0; $i < $arraySize; $i++)
	{

		if ($stringArray[$i] == ' ')
		{
			$space = true;
		}
		if ($stringArray[$i] == '.')
		{
			$period = true;
		}
		if ($stringArray[$i] == '0')
		{
			$number = true; 
		}
		if ($stringArray[$i] == '1')
		{
			$number = true;
		}
		if ($stringArray[$i] == '2')
		{
			$number = true;
		}
		if ($stringArray[$i] == '3')
		{
			$number = true;
		}
		if ($stringArray[$i] == '4')
		{
			$number = true;
		}
		if ($stringArray[$i] == '5')
		{
			$number = true;
		}
		if ($stringArray[$i] == '6')
		{
			$number = true;
		}
		if ($stringArray[$i] == '7')
		{
			$number = true;
		}
		if ($stringArray[$i] == '8')
		{
			$number = true;
		}	
		if ($stringArray[$i] == '9')
		{
			$number = true;
		}
	}
	
	//db connection
	$conn = dbConnect();
	$taken = false;	
	//check if this school exists already
	//----------------check for school existence-----------------------------------
        //query string
        $query = "select school_name from schools where school_name = '";
        $query .= $_SESSION["school_name"];
        $query .= "';";

        //get db result
        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

       	//get numer of rows
        $num = pg_num_rows($result);
	echo "num:";
	echo $num; 
	echo "<br>";

        // if there is a row then the username and password pair exists
        if ($num == 1)
        {
		$taken = true;
	}

	if ($taken || $number || $period || $space || $_SESSION["school_name"] == '')
	{
		if ($taken)
		{
        		header("Location: ../signup/signup_nametaken.php");
		}
		if ($space)
		{
        		header("Location: ../signup/signup_nospaces.php");
		}
		if ($number)
		{
        		header("Location: ../signup/signup_nonumbers.php");
		}
		if ($period)
		{
        		header("Location: ../signup/signup_noperiods.php");
		}
		if ($_SESSION["school_name"] == '')
		{
        		header("Location: ../signup/signup_nousername.php");
		}
	}
	else	
	{
		//--------------------INSERT INTO SCHOOL----------------
		//query string 	
		$query = "INSERT INTO schools (school_name) VALUES ('";
		$query .= $_SESSION["school_name"];
		$query .= "'"; 
		$query .= ");";      	

		// insert into schools......
		$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
       		dbErrorCheck($conn,$result);
 		
		//----------------SCHOOL CHECK----------------------------------------------
       		//query string
       		$query = "select id from schools where school_name = '";
       		$query .= $_SESSION["school_name"];
       		$query .= "';";

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
               		$school_id = pg_Result($result, 0, 'id');

               		//set user id, and subject levels to be used later
               		$_SESSION["school_id"] = $school_id;
       		}
       		else
       		{
               		//we are not a school
               		$_SESSION["is_school"] = "FALSE";
               		$_SESSION["school_name"] = "";
       		}

		//--------------------INSERT INTO USERS----------------
                //query string
                $query = "INSERT INTO users (username, password, school_id) VALUES ('";
                $query .= $_SESSION["username"];
                $query .= "','";
                $query .= $_SESSION["password"];
                $query .= "',";
		$query .= $school_id;
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

 			
		//----------------USER CHECK----------------------------------------------
       		//query string
       		$query = "select id, first_name, last_name from users where school_id = ";
       		$query .= $school_id;
       		$query .= " and ";
       		$query .= "username = 'root';";

       		//get db result
       		$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
       		dbErrorCheck($conn,$result);

       		//get numer of rows
       		$num = pg_num_rows($result);

       		// if there is a row then the username and password pair exists
       		if ($num > 0)
       		{
               		//get the id from user table
               		$id = pg_Result($result, 0, 'id');
               		$first_name = pg_Result($result, 0, 'first_name');
               		$last_name = pg_Result($result, 0, 'last_name');

               		//set login var to yes
               		$_SESSION["Login"] = "YES";

               		//set user id, and subject levels to be used later
               		$_SESSION["is_user"] = "TRUE"; 
               		$_SESSION["user_id"] = $id;
               		$_SESSION["first_name"] = $first_name;
               		$_SESSION["last_name"] = $last_name;
       		}
       		else
       		{
               		//set login cookie to no
               		$_SESSION ["Login"] = "NO";
       		}

		//--------------------INSERT INTO ADMINS----------------
                //query string
                $query = "INSERT INTO admins (user_id) VALUES (";
                $query .= $_SESSION["user_id"];
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

                //--------------------INSERT INTO TEACHERS----------------
                //query string
                $query = "INSERT INTO teachers (user_id) VALUES (";
                $query .= $_SESSION["user_id"];
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

                //--------------------INSERT INTO STUDENTS----------------
                //query string
                $query = "INSERT INTO students (user_id) VALUES (";
                $query .= $_SESSION["user_id"];
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);



		//----------------STUDENT CHECK----------------------------------------------
       		//is this user a student? if so let's set some session vars
       		//query string
       		$query = "select id, math_level, english_level from students where user_id = ";
       		$query .= $_SESSION["user_id"];
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
               		$student_id = pg_Result($result, 0, 'id');
               		$mathLevel = pg_Result($result, 0, 'math_level');
               		$englishLevel = pg_Result($result, 0, 'english_level');

               		//set user id, and subject levels to be used later
               		$_SESSION["student_id"] = $student_id;
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
       		$query = "select id from admins where user_id = ";
       		$query .= $_SESSION["user_id"];
       		$query .= ";";

       		//get db result
       		$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
       		dbErrorCheck($conn,$result);

       		//get numer of rows
       		$num = pg_num_rows($result);

       		if ($num > 0)
       		{
               		//get the id from user table
               		$admin_id = pg_Result($result, 0, 'id');
                		
			//we are an admin
               		$_SESSION["admin_id"] = $admin_id;
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
       		$query .= $_SESSION["user_id"];
       		$query .= ";";

       		//get db result
       		$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
       		dbErrorCheck($conn,$result);

       		//get numer of rows
       		$num = pg_num_rows($result);

       		if ($num > 0)
       		{
               		//get the id from user table
               		$teacher_id = pg_Result($result, 0, 'id');
               		
			//we are a teacher
               		$_SESSION["teacher_id"] = $teacher_id;
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

	}
?>

