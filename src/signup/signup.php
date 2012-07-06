<?php include("../database/db_connect.php"); ?>
<?php include("../database/query_levels.php"); ?>
<?php include("../database/insert_into_schools.php"); ?>
<?php include("../database/insert_into_users.php"); ?>
<?php include("../database/insert_into_teachers.php"); ?>
<?php include("../database/insert_into_students.php"); ?>

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
		//insert school
		$school_id = insertIntoSchools($conn,$_SESSION["school_name"]);
                if ($school_id)
                {      
                        $_SESSION["is_school"] = "TRUE";
                        $_SESSION["school_id"] = $school_id;
                }
                else
                {
                        $_SESSION["is_school"] = "FALSE";
                        $_SESSION["school_id"] = 0;
                        $_SESSION["school_name"] = "";
                }
		//insert user
		$user_id = insertIntoUsers($conn,$_SESSION["username"], $_SESSION["password"], $_SESSION["school_id"]);
		if ($user_id)
		{	 
                	//set sessions 
                	$_SESSION["Login"] = "YES";
                        $_SESSION["is_user"] = "TRUE";
                        $_SESSION["user_id"] = $user_id;
		}
		else
		{
                	$_SESSION["Login"] = "NO";
		}

 		//insert teacher 
                $teacher_id = insertIntoTeachers($conn,$_SESSION["user_id"]);
                if ($school_id)
                {
                        $_SESSION["is_teacher"] = "TRUE";
                        $_SESSION["teacher_id"] = $teacher_id;
                }
                else
                {
                        $_SESSION["is_teacher"] = "FALSE";
                        $_SESSION["teacher_id"] = 0;
                }

	   	//insert student 
                $student_id = insertIntoStudents($conn,$_SESSION["user_id"]);
                if ($school_id)
                {
                        $_SESSION["is_student"] = "TRUE";
                        $_SESSION["student_id"] = $student_id;
                }
                else
                {
                        $_SESSION["is_student"] = "FALSE";
                        $_SESSION["student_id"] = 0;
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

