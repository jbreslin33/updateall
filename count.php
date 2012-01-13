<html>
<body>

<?php

session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
        header("Location: login_form.php");
}


$math_game_level = $_SESSION["math_game_level"];

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

//get game parameters...
//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") 
or die('Could not connect: ' . pg_last_error());

//query
$query = "select name, start_number, end_number ";
$query .= "from math_games ";
$query .= "where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";


echo "<h1> Query: $query </h1>";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$num = pg_num_rows($result);

echo "<h1>  Number of Rows: $num </h1>";

$name = "";
$start_number = 0;
$end_number = 0; 

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        $row = pg_fetch_row($result);
        $name = $row[0];
	$start_number = $row[1];
	$end_number = $row[2];
}

echo "<h1> name: $name </h1>";
echo "<h1> start_number: $start_number </h1>";
echo "<h1> end_number: $end_number </h1>"; 




?>

</body>
</html> 
