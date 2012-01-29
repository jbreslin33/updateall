<html>
<body>

<?php include("check_login.php"); ?>
<?php include("db_connect.php"); ?>

<?php

//db connection
$conn = dbConnect();

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

<!-- class for counting games -->
<?php include("game_count.php"); ?>

<!-- creating game which is child of game --> 
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question --> 
<p id="question"> </p>

<div id="buttoncontent"> </div>

<!-- Create Buttons (could this be done in db?) --> 
<?php 

$i=1;
for ($i=1; $i < $numberOfButtons + 1; $i++)
{
	echo "<button type=\"button\" id=\"button$i\" onclick=\"game.submitGuess(this.id)\"> </button> ";
}

?>

<!-- initialize variables for start of new game or reset --> 
<script type="text/javascript"> game.resetVariables(); </script>

<!-- newQuestion --> 
<script type="text/javascript"> game.newQuestion(); </script>

<!-- newAnswer --> 
<script type="text/javascript"> game.newAnswer(); </script>

<!-- call setChoices to initialize their innerhtml --> 
<script type="text/javascript"> game.setChoices(); </script>

<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<!-- call printScore --> 
<script type="text/javascript"> game.printScore(); </script>

</body>
</html> 
