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

//school attempt
if ($period_count == 0)
{
	header("Location: login_form.php?message=no_periods");	
}

//non school attempt
if ($period_count == 1)
{
	header("Location: login_form.php?message=one_period");	
}

//invalid attempt
if ($period_count == 2)
{
	header("Location: login_form.php?message=too_many_periods");	
}
	pg_close();
?>

