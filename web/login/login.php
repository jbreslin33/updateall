<?php
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/set_level_session_variables.php");

include(getenv("DOCUMENT_ROOT") . "/src/database/select_school_id.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/select_user_id.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/select_student_id.php");

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

//set school sesssion
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

//set user sessions
$user_id = selectUserID($conn, $_SESSION["school_id"],$_SESSION["username"],$_SESSION["password"]);
if ($user_id)
{
	//set sessions
        $_SESSION["user_id"] = $user_id;
      	$_SESSION["Login"] = "YES";
	setLevelSessionVariables($conn,$user_id);
}
else
{
        $_SESSION["Login"] = "NO";
	$problem = "no_user";	
       	$_SESSION["user_id"] = 0;
}

if ($problem == "")
{
        header("Location: /web/home/home.php");
}
else
{
        header("Location: login_form.php?message=$problem");
}

pg_close();
?>

