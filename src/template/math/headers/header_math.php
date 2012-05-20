<html>
<head>

<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="../../../mootools/mootools-core-1.4.5-full-compat.js"></script>

<?php 
include("../../../login/check_login.php");
include("../../../database/db_connect.php");

//db connection
$conn = dbConnect();

//query the level table
$query = "select skill, next_level from math_levels where level = ";
$query .= $_SESSION["math_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$skill = "";
$nextLevel = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $skill = $row[0];
	$nextLevel = $row[1];
	
	$_SESSION["math_next_level"] = $nextLevel;
}
?>
