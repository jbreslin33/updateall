<html>
<body>

<?php include("check_login.php"); ?>
<?php include("db_connect.php"); ?>

<?php

//db connection
$conn = dbConnect();

//query
$query = "select name, start_number, end_number from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$startNumber = 0;
$endNumber = 0; 

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
	$endNumber = $row[2];
}

?>

<script type="text/javascript">

//set javascript vars from db result set
var question = 0;
var guess = 0;
var questionString = 0;

function submitGuess(button_id)
{
        guess = document.getElementById(button_id).innerHTML;
        checkGuess();
}

function checkGuess()
{
        if (guess == answer)
        {
                document.getElementById("feedback").innerHTML="Correct!";
                
		newQuestion();
		newAnswer();		
        	checkForEndOfGame();        	
        }
        else
        {
                document.getElementById("feedback").innerHTML="Wrong! Try again.";

		resetVariables();	

		newQuestion();
		newAnswer();

       
		setButtons(question);         
        }
}

function checkForEndOfGame()
{
	if (question == <?php echo "$endNumber"; ?> )
        {
        	document.getElementById("feedback").innerHTML="YOU WIN!!!";
		window.location = "goto_next_math_level.php"					
        }
}

function newQuestion()
{
	question++;
	var offset = Math.floor(Math.random() *2);
        offset = question - offset;
	questionString = questionString + ' ' + question;
	document.getElementById("question").innerHTML=questionString;
	setButtons(offset);
}

function newAnswer()
{
	answer++;
}

function resetVariables()
{
	<?php 
	echo "question 	= $startNumber;";
	?>	
	answer = question + 1;	
	guess = 0;		
	questionString = "";	

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
<p id="question"> <?php echo "$startNumber"; ?>  </p>

<!-- Create Buttons (could this be done in db?) -->
<button type="button" id="button1" onclick="submitGuess(this.id)"> </button>
<button type="button" id="button2" onclick="submitGuess(this.id)"> </button>
<button type="button" id="button3" onclick="submitGuess(this.id)"> </button>
<button type="button" id="button4" onclick="submitGuess(this.id)"> </button>

<!-- initialize variables for start of new game or reset --> 
<script type="text/javascript"> resetVariables(); </script>

<!-- call setButtons to initialize their innerhtml --> 
<script type="text/javascript"> setButtons( <?php echo "$startNumber"; ?> ); </script>


<!-- create feedback -->
<p id="feedback"></p>

</body>
</html> 
