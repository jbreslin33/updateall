
<html>
<body>

<?php
session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
	header("Location: login_form.php");
}
//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

$id = $_SESSION["id"];

//query string
$query = "select math_game_level ";
$query .= "from users ";
$query .= "where id = ";
$query .= $id;

$query .= ";";

echo "<h1> Query: $query </h1>";

//get db restult
$dbResult = pg_query($query);


//check for db error
if (!$dbResult)
{
       die("Database error math_game_level...");
}

//get numer of rows
$num = pg_num_rows($dbResult);

//echo "<h1>  Number of Rows: $num </h1>";

?>



</body>
</html>
