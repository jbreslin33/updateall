<?php include("../database/db_connect.php"); ?>

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

//first we need school_id regardless of whether this user is a school or not so we can check if they 
//exist
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
                
                //get the id from user table    
                $school_id = pg_Result($result, 0, 'id');
                
                //set school_id                       
                $_SESSION["school_id"] = $school_id;        
        }
        else
        {
                //no record
                $_SESSION["school_id"] = 0;        
		$problem = "no_school";	
	}

//now we have a valid school_id to query users table to see if they exist and then set sessions
	//query string
        $query = "select id, first_name, last_name from users where school_id = ";
        $query .= $_SESSION["school_id"];
        $query .= " and username = '";
        $query .= $_SESSION["username"];
        $query .= "' and password = '";
        $query .= $_SESSION["password"];
        $query .= "';";

        //get db result
        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
        dbErrorCheck($conn,$result);

        //get numer of rows
        $num = pg_num_rows($result);

        if ($num > 0)
        {

                //get the id from user table
                $user_id = pg_Result($result, 0, 'id');
                $first_name = pg_Result($result, 0, 'first_name');
                $last_name = pg_Result($result, 0, 'last_name');

                //set user id, and first and last name to be used later
                $_SESSION["user_id"] = $user_id;
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
		
		//set login var to yes  
                $_SESSION["Login"] = "YES";

        }
        else
        {
		//set login var to yes  
                $_SESSION["Login"] = "NO";
                $_SESSION["user_id"] = 0;

                //no record
		$problem = "no_user";	
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
                                $_SESSION["is_teacher"] = "TRUE";
                        }
                        else
                        {
                                //we are not a teacher
                                $_SESSION["teacher_id"] = 0;
                                $_SESSION["is_teacher"] = "FALSE";
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
                                $_SESSION["is_student"] = "TRUE";

                                //get the id from user table
                                $student_id = pg_Result($result, 0, 'id');

                                //set user student_id
                                $_SESSION["student_id"] = $student_id;
                        }
                        else
                        {
                                //we are not a student
                                $_SESSION["is_student"] = "FALSE";
                                $_SESSION["student_id"] = 0;
                        }

//---------------------------------------FIND Last LEVEL---------------------------
//this query could be more efficient maybe
$query = "select advancement_time, level_id from levels_transactions where student_id = ";
$query .= $_SESSION["student_id"];
$query .= " ORDER BY advancement_time DESC LIMIT 1";
$query .= ";";

 //get db result
                        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                        dbErrorCheck($conn,$result);

                        //get numer of rows
                        $num = pg_num_rows($result);

                        if ($num > 0)
                        {
                                //get the id from user table
                                $level_id = pg_Result($result, 0, 'last_level_id');

                                //set level_id
                                $_SESSION["last_level_id"] = $level_id;
                        }
                        else
                        {
                                // no transaction in level_transactions so set level_id to 1
			 	echo "error no transactions";	
                        }
//*****************************
  //---------------- GET starting level id and next level id ----------------------------------------------
/*
                $query = "select id from levels order by level LIMIT 2;";

                //get db result
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

                //get numer of rows
                $num = pg_num_rows($result);

                if ($num > 1)
                {
                        //get the id from user table
                        $completed_level_id = pg_Result($result, 0, 'id');
                        $next_level_id = pg_Result($result, 1, 'id');

                        //we are a teacher
                        $_SESSION["completed_level_id"] = $completed_level_id;
                        $_SESSION["next_level_id"] = $next_level_id;
                }
                else
                {
                        echo "error no results";
                }
*/
                //---------------- insert that level as your first level_transaction ----------------------------------------------
/* 
               $query = "insert into levels_transactions (advancement_time, level_id,student_id) values (current_timestamp,";
                $query .= $_SESSION["completed_level_id"];
                $query .= ",";
                $query .= $_SESSION["student_id"];
                $query .= ");";

                //db call to update
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

                //--------------------------------------------------------------
                header("Location: ../template/main/main.php");

                //close db connection as we have the only var we needed - the id
                pg_close();
*/



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

