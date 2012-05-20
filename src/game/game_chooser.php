<?php include("../login/check_login.php"); ?>
<?php include("../database/db_connect.php"); ?>

<?php

//db connection
$conn = dbConnect();

//------math game level-----------------------------------------------

//query string
$query = "select math_game_level from users where id = ";
$query .= $_SESSION["id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	$row = pg_fetch_row($result);
	$_SESSION["math_game_level"] = $row[0];	
	header("Location: ../template/chooser_game_math.php");
}
else
{
	header("Location: ../login/login_form.php");
}

?>
