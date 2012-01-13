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


//get user id and store it in session var
//$name = pg_Result ($dbResult, 0, 'name');
//$start_number = pg_Result ($dbResult, 0, 'start_number');
//$end_number = pg_Result ($dbResult, 0, 'end_number');


?>

</body>
</html> 
