<?php include("../database/db_connect.php"); ?>
<?php include("../database/set_level_session_variables.php"); ?>
<?php include("../database/insert_into_schools.php"); ?>
<?php include("../database/insert_into_users.php"); ?>
<?php include("../database/insert_into_teachers.php"); ?>
<?php include("../database/insert_into_students.php"); ?>
<?php include("../database/insert_first_level_transaction.php"); ?>
<?php include("../database/check_for_periods.php"); ?>
<?php include("../database/check_for_spaces.php"); ?>
<?php include("../database/check_for_numbers.php"); ?>
<?php include("../database/check_for_schools.php"); ?>

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

	$period = checkForPeriods($schoolnameString);
	$space = checkForSpaces($schoolnameString);
	$number = checkForNumbers($schoolnameString);

	$taken = checkForSchools($conn,$_SESSION["school_name"]);

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
                        $_SESSION["school_id"] = $school_id;
                }
                else
                {
                        $_SESSION["school_id"] = 0;
                        $_SESSION["school_name"] = "";
                }
		//insert user
		$user_id = insertIntoUsers($conn,$_SESSION["username"], $_SESSION["password"], $_SESSION["school_id"]);
		if ($user_id)
		{	 
                	//set sessions 
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
                        $_SESSION["teacher_id"] = $teacher_id;
                }
                else
                {
                        $_SESSION["teacher_id"] = 0;
                }

	   	//insert student 
                $student_id = insertIntoStudents($conn,$_SESSION["user_id"]);
                if ($school_id)
                {
                        $_SESSION["student_id"] = $student_id;
                }
                else
                {
                        $_SESSION["student_id"] = 0;
                }

		insertFirstLevelTransaction($conn,$_SESSION["student_id"]);

		//set session levels
		setLevelSessionVariables($conn);


       		//--------------------------------------------------------------
                
		$_SESSION["Login"] = "YES";
       		header("Location: ../template/main/main.php");
       		
		//close db connection as we have the only var we needed - the id
       		pg_close();

	}
?>

