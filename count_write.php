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
var answers = new Array();
answers[0] = "0";
answers[1] = "1";
answers[2] = "2";
answers[3] = "3";
answers[4] = "4";
answers[5] = "5";
answers[6] = "6";
answers[7] = "7";
answers[8] = "8";
answers[9] = "9";
answers[10] = "1";
answers[11] = "0";
answers[12] = "1";
answers[13] = "1";
answers[14] = "1";
answers[15] = "2";
answers[16] = "1";
answers[17] = "3";
answers[18] = "1";
answers[19] = "4";
answers[20] = "1";
answers[21] = "5";
answers[22] = "1";
answers[23] = "6";
answers[24] = "1";
answers[25] = "7";
answers[26] = "1";
answers[27] = "8";
answers[28] = "1";
answers[29] = "9";
answers[30] = "2";
answers[31] = "0";



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
	question = question + ' ' + answers[count];
	document.getElementById("question").innerHTML=question;
}

function setChoices()
{
	//set buttons	
	var offset = Math.floor(Math.random() *4);
        offset = answer - offset;
	setButtons(0);
}

function newAnswer()
{
	answer = answers[count + countBy];
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
	<?php	
	$i=1;
	for ($i=1; $i < $numberOfButtons; $i++)
	{
		$j = $i - 1;	
		echo "document.getElementById(\"button$i\").innerHTML=offset + $j;";
	}

		
	echo "document.getElementById(\"button$i\").innerHTML=\"SPACE\";";
	?>	
}

</script>

<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question -->
<p id="question"> </p>

<!-- Create Buttons (could this be done in db?) --> 
<?php 

$i=1;
for ($i=1; $i < $numberOfButtons + 1; $i++)
{
	echo "<button type=\"button\" id=\"button$i\" onclick=\"submitGuess(this.id)\"> </button> ";
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
