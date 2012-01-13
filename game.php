
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
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

//------math game level-----------------------------------------------

//query string
$query = "select math_game_level ";
$query .= "from users ";
$query .= "where id = ";
$query .= $_SESSION["id"];
$query .= ";";

echo "<h1> Query: $query </h1>";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$num = pg_num_rows($result);

echo "<h1>  Number of Rows: $num </h1>";

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	$row = pg_fetch_row($result);
	$_SESSION["math_game_level"] = $row[0];	
}

echo "<h1> math_game_level:";
echo $_SESSION["math_game_level"];
echo "</h1>";

//--------------------------url----------------------
echo "<h1> URL Section </h1>";
//sql query 
//query string
$query = "select url ";
$query .= "from math_games ";
$query .= "where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db restult for url
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows 
$num = pg_num_rows($result);
echo "<h1>  Number of Rows: $num </h1>";

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	$row = pg_fetch_row($result);
	$_SESSION["url"] = $row[0];
	echo "<h1> url: ";
	echo $_SESSION["url"];
	echo "</h1>";

	//header("Location: $_SESSION[\"url\"]");
	header("Location: $row[0]");
}

?>



</body>
</html>
