<?php include("../database/db_connect.php"); ?>

<?php
	//db connection
	$conn = dbConnect();

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

        echo $_SESSION["school_name"];
	echo "<br>"; 
        echo $_SESSION["username"];
	

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
                
                //set user id, and subject levels to be used later                      
                $_SESSION["school_id"] = $school_id;        
        }
        else
        {
                //no record
		header("Location: login_form.php?message=no_school");	
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

                //set user id, and subject levels to be used later
                $_SESSION["user_id"] = $school_id;
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
                //header("Location: ../template/main/main.php");
        }
        else
        {
                //no record
                header("Location: login_form.php?message=no_user");
        }

//now we need to select the rest of the tables now not we have a legit user so we can properly fill out session vars and thus overwrite old values.
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

                header("Location: ../template/main/main.php");
pg_close();
?>

