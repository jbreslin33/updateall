<?php include("../database/db_connect.php"); ?>

<?php
	//db connection
	$conn = dbConnect();

$usernameString = $_POST["username"];

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


$school_name;
$username;

$before_period = true;
$before_period_array = "";
$after_period_array = "";

//school attempt
if ($period_count == 0)
{
	$_SESSION["school_name"] = $_POST["username"];
	$_SESSION["username"] = "";
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

	pg_close();
?>

