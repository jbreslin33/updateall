<?php include("../database/db_connect.php"); ?>
<?php include("../database/set_level_session_variables.php"); ?>
<?php include("../database/select_school_id.php"); ?>
<?php include("../database/select_user_id.php"); ?>
<?php include("../database/select_teacher_id.php"); ?>
<?php include("../database/select_student_id.php"); ?>

<?php
//db connection
$conn = dbConnect();

//start new session
session_start();

$usernameString = $_POST["username"];
$_SESSION["password"] = $_POST["password"];

//first let's check amount of periods 
$stringArray = str_split($usernameString);

$arraySize = count($stringArray);

//let's add up periods
$period_count = 0;
for ($i=0; $i < $arraySize; $i++)
{
	if ($stringArray[$i] == '.')
        {
        	$period_count++;
        }
}

$before_period = true;
$before_period_array = "";
$after_period_array = "";

//school attempt
if ($period_count == 0)
{
	$_SESSION["school_name"] = $_POST["username"];
	$_SESSION["username"] = "root";
}

//non school attempt
if ($period_count == 1)
{
	for ($i=0; $i < $arraySize; $i++)
	{
        
		if ($stringArray[$i] == '.')
        	{
                	$before_period = false;
			continue;
        	}

        	if ($before_period)
		{
			$before_period_array .= $stringArray[$i];		
		}
		else
		{
			$after_period_array .= $stringArray[$i];		
		}
	}
	$_SESSION["school_name"] = $after_period_array;
	$_SESSION["username"] = $before_period_array;
}

//invalid attempt
if ($period_count == 2)
{
	header("Location: login_form.php?message=too_many_periods");	
}

//let's set a var that will be false if there was a problem..
$problem = "";

$school_id = selectSchoolID($conn,$_SESSION["school_name"]);
if ($school_id)
{
	$_SESSION["school_id"] = $school_id;
}
else
{
	$_SESSION["school_id"] = 0;
        $_SESSION["school_name"] = "";
	$problem = "no_school";	
}

  $user_id = selectUserID($conn, $_SESSION["school_id"],$_SESSION["username"],$_SESSION["password"]);
                if ($user_id)
                {
                        //set sessions
                        $_SESSION["user_id"] = $user_id;
                	$_SESSION["Login"] = "YES";
                }
                else
                {
                        $_SESSION["Login"] = "NO";
			$problem = "no_user";	
                	$_SESSION["user_id"] = 0;
                }





//now we need to select the rest of the tables now not we have a legit user so we can properly fill out session vars and thus overwrite old values.
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
                        }
                        else
                        {
                                //we are not a teacher
                                $_SESSION["teacher_id"] = 0;
                        }

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

                                //get the id from user table
                                $student_id = pg_Result($result, 0, 'id');

                                //set user student_id
                                $_SESSION["student_id"] = $student_id;
                        }
                        else
                        {
                                //we are not a student
                                $_SESSION["student_id"] = 0;
                        }

setLevelSessionVariables($conn);


	if ($problem == "")
	{
                header("Location: ../template/main/main.php");
	}
	else
	{
                header("Location: login_form.php?message=$problem");
	}
pg_close();
?>

