<?php

include("top.php");

//query
$query = "select name, start_number, score_needed, count_by, number_of_buttons from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$startNumber = 0;
$scoreNeeded = 0; 
$countBy = 0;
$numberOfButtons = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//get row
        $row = pg_fetch_row($result);
       	
	//fill php vars from db 
	$name = $row[0];
	$startNumber = $row[1];
	$scoreNeeded = $row[2];
	$countBy = $row[3];
	$numberOfButtons = $row[4];
}

?>

<!-- class for game -->
<?php include("game_count_write.php"); ?>

<!-- creating game --> 
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<!-- lower.php -->
<?php include("lower.php"); ?>
