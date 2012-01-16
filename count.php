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

<script type="text/javascript">

//set javascript vars from db result set
var question = ""; //use to ask actuall question
var guess = 0; // the users guess to question
var count = 0; //this aids in asking the next question
var answer = 0; //this is the correct answer to use for comparison to guess
var score = 0;
var countBy = 0;
var numberOfButtons = 0;

function submitGuess(button_id)
{
        guess = document.getElementById(button_id).innerHTML;
        checkGuess();
}

function checkGuess()
{
        if (guess == answer)
        {
		count = count + countBy;  //add to count            	
 		score++; 
              	
		document.getElementById("feedback").innerHTML="Correct!";
		
        	checkForEndOfGame();        	
        }
        else
        {
                document.getElementById("feedback").innerHTML="Wrong! Try again.";

		resetVariables();	
        }
	
	printScore();	

	newQuestion();
	newAnswer(); 	
	setChoices();	
}

function printScore()
{
	document.getElementById("score").innerHTML="Score: " + score;
	document.getElementById("scoreNeeded").innerHTML="Score Needed: " + scoreNeeded;
}

function checkForEndOfGame()
{
	if (score == <?php echo "$scoreNeeded"; ?> )
        {
        	document.getElementById("feedback").innerHTML="YOU WIN!!!";
		window.location = "goto_next_math_level.php"					
        }
}

function newQuestion()
{
	//set question	
	question = question + ' ' + count;
	document.getElementById("question").innerHTML=question;
}

function setChoices()
{
	//set buttons	
	var offset = Math.floor(Math.random() *2);
        offset = answer - offset;
	setButtons(offset);
}

function newAnswer()
{
	answer = count + countBy;
}

function resetVariables()
{
	question = "";	
	<?php echo "count = $startNumber;"; ?>
	guess = 0;		
	answer = 0;
	score = 0;
	<?php echo "scoreNeeded = $scoreNeeded;"; ?>
	<?php echo "countBy = $countBy;"; ?>		
	<?php echo "numberOfButtons = $numberOfButtons;"; ?>
}

<!-- set buttons inner html -->
function setButtons(offset)
{
	document.getElementById("button1").innerHTML=offset;
        document.getElementById("button2").innerHTML=offset + 1;
	document.getElementById("button3").innerHTML=offset + 2;
        document.getElementById("button4").innerHTML=offset + 3;
}

</script>

<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question --> 
<p id="question"> </p>


<!-- Create Buttons (could this be done in db?) --> 
<?php 

//for ($i=1; $i<$number_of_buttons; $i++)
//{
$a=1;
for ($a=1; $a < $numberOfButtons + 1; $a++)
{

echo "<button type=\"button\" id=\"button$a\" onclick=\"submitGuess(this.id)\"> </button> ";
//echo "<button type=\"button\" id=\"button2\" onclick=\"submitGuess(this.id)\"> </button> ";
//echo "<button type=\"button\" id=\"button3\" onclick=\"submitGuess(this.id)\"> </button> ";
//echo "<button type=\"button\" id=\"button4\" onclick=\"submitGuess(this.id)\"> </button> ";

}

?>

<!-- initialize variables for start of new game or reset --> 
<script type="text/javascript"> resetVariables(); </script>

<!-- newQuestion --> 
<script type="text/javascript"> newQuestion(); </script>

<!-- newAnswer --> 
<script type="text/javascript"> newAnswer(); </script>

<!-- call setChoices to initialize their innerhtml --> 
<script type="text/javascript"> setChoices(); </script>


<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<!-- call printScore --> 
<script type="text/javascript"> printScore(); </script>

</body>
</html> 
