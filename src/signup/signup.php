<?php include("../database/db_connect.php"); ?>
<?php include("../database/query_levels.php"); ?>
<?php include("../database/insert_into_schools.php"); ?>

<?php

	//db connection
	$conn = dbConnect();
        
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
	
	//----------------check for school existence-----------------------------------
	$taken = false;	
        
	//query string
        $query = "select school_name from schools where school_name = '";
        $query .= $_SESSION["school_name"];
        $query .= "';";

        //get db result
        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

       	//get numer of rows
        $num = pg_num_rows($result);

        // if there is a row then the username and password pair exists
        if ($num == 1)
        {
		$taken = true;
	}

	if ($taken || $number || $period || $space || $_SESSION["school_name"] == '')
	{
		if ($taken)
		{
        		header("Location: ../signup/signup_form.php?message=name_taken");
		}
		if ($space)
		{
        		header("Location: ../signup/signup_form.php?message=no_spaces");
		}
		if ($number)
		{
        		header("Location: ../signup/signup_form.php?message=no_numbers");
		}
		if ($period)
		{
        		header("Location: ../signup/signup_form.php?message=no_periods");
		}
		if ($_SESSION["school_name"] == '')
		{
        		header("Location: ../signup/signup_form.php?message=no_name");
		}
	}
	else	
	{
		insertIntoSchools($conn,$_SESSION["school_name"]);

		//--------------------INSERT INTO USERS----------------
                //query string
                $query = "INSERT INTO users (username, password, school_id) VALUES ('";
                $query .= $_SESSION["username"];
                $query .= "','";
                $query .= $_SESSION["password"];
                $query .= "',";
		$query .= $_SESSION["school_id"];
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

 			
		//----------------USER CHECK----------------------------------------------
       		//query string
       		$query = "select id from users where school_id = ";
       		$query .= $_SESSION["school_id"];
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

               		
			//set sessions 
               		$_SESSION["is_user"] = "TRUE"; 
               		$_SESSION["user_id"] = $id;
       		}
       		else
       		{
               		//set login cookie to no
               		$_SESSION ["Login"] = "NO";
       		}

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
       		$query = "select id from students where user_id = ";
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

               		//set sessions vars 
               		$_SESSION["student_id"] = $student_id;
       		}
       		else
       		{
               		//we are not a student
               		$_SESSION["is_student"] = "FALSE";
               		$_SESSION["student_id"] = 0;
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
               		$_SESSION["teacher_id"] = 0;
       		}

       		//---------------- GET starting level id and next level id ----------------------------------------------
                $query = "select id from levels order by level LIMIT 2;";

                //get db result
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

                //get numer of rows
                $num = pg_num_rows($result);

                if ($num > 1)
                {
                        //get the id 
                        $completed_level_id = pg_Result($result, 0, 'id');

			//set session
                        $_SESSION["completed_level_id"] = $completed_level_id;
                }
                else
                {
               		echo "error no results"; 
		}

       		//---------------- insert that level as your first level_transaction ----------------------------------------------
		$query = "insert into levels_transactions (advancement_time, level_id,student_id) values (current_timestamp,";
		$query .= $_SESSION["completed_level_id"];
		$query .= ",";
		$query .= $_SESSION["student_id"];
		$query .= ");";

		//db call to update
		$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

		//set session levels
		setLevelSessionVariables($conn);


       		//--------------------------------------------------------------
       		header("Location: ../template/main/main.php");
       		
		//close db connection as we have the only var we needed - the id
       		pg_close();

	}
?>

