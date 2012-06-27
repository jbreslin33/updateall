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
        $query .= " and password = '";
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
                $school_id = pg_Result($result, 0, 'id');
                $first_name = pg_Result($result, 0, 'first_name');
                $last_name = pg_Result($result, 0, 'last_name');

                //set user id, and subject levels to be used later
                $_SESSION["school_id"] = $school_id;
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
        }
        else
        {
                //no record
                header("Location: login_form.php?message=no_user");
        }


pg_close();
?>

