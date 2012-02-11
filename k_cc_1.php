<html>

<!-- jquery and jqueryui -->
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>

<body>
<?php

include("check_login.php");
include("db_connect.php");

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

<!-- class for game -->
<script type="text/javascript">

var score = 0;
var scoreNeeded = 0;
var numberOfQuestions = 0;
var question = 0;
var guess = 0;
var answer = 0;
var countBy = 0;
var count = 0;
var startNumber = 0;
var xpos = 0;
var ypos = 0; 



function Game(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	//score
	scoreNeeded = scoreNeeded;

	//game
	numberOfButtons = numberOfButtons;

	//count
	countBy = countBy;
	startNumber = startNumber;
}


//Score
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

//reset
function resetVariables()
{
	//score
	score = 0;

	//game
        question = "";
        guess = 0;
        answer = 0;

	//count
        count = startNumber;
}

//check guess
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
}

//questions
function newQuestion()
{
        //set question
        question = question + ' ' + count;
        document.getElementById("question").innerHTML=question;
}

//set choices
function setChoices()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = answer - offset;
        setButtons(offset);
}

//new answer
function newAnswer()
{
        answer = count + countBy;
}

//set buttons
function setButtons(offset)
{
	document.getElementById("buttonMoveLeft").innerHTML="left";
	document.getElementById("buttonMoveRight").innerHTML="right";
	document.getElementById("buttonMoveUp").innerHTML="up";
	document.getElementById("buttonMoveDown").innerHTML="down";
	document.getElementById("buttonMoveStop").innerHTML="stop";
}


var userWidth = window.screen.width;


var positionX = 0; //Starting Location - left
var positionY = 0; //Starting Location - top

var velocityX = 0;
var velocityY = 0;

var dest_x = 300;  //Ending Location - left
var dest_y = 300;  //Ending Location - top
var interval = 1; //Move 10px every initialization

function move()
{
        //Move the image to the new location
	//var tempx = document.getElementById("redball1").style.left + x;
	//var tempy = document.getElementById("redball1").style.top + y;
      
	positionX = positionX + velocityX;
	positionY = positionY + velocityY;

	if (positionX < 0)
	{
		positionX = 0; 
	} 
	if (positionX > 600)
	{
		positionX = 600; 
	} 
	if (positionY < 0)
	{
		positionY = 0; 
	} 
	if (positionY > 600)
	{
		positionY = 600; 
	} 
	


	document.getElementById("redball1").style.left = positionX+'px';
        document.getElementById("redball1").style.top  = positionY+'px';
        window.setTimeout('move()',16);
}

function moveDown333() {
        //Keep on moving the image till the target is achieved
        if(x<dest_x) x = x + interval;
        if(y<dest_y) y = y + interval;

        //Move the image to the new location
        document.getElementById("redball1").style.left = x+'px';
        document.getElementById("redball1").style.top  = y+'px';

        if ((x+interval < dest_x) && (y+interval < dest_y)) {
                //Keep on calling this function every 100 microsecond
                //      till the target location is reached
                window.setTimeout('moveDown()',16);
        }
}

function moveLeft()
{
	velocityX = -1;
        velocityY = 0;
}

function moveRight()
{
	velocityX = 1;
        velocityY = 0;
}

function moveUp()
{
       	velocityX = 0;
	velocityY = -1;
}

function moveDown()
{
        velocityX = 0;
	velocityY = 1;
}

function moveStop()
{
        velocityX = 0;
        velocityY = 0;
}
var keynum;

function moveKey(e)
{
	if(window.event) // IE8 and earlier
	{
		//	keynum = e.keyCode;
		//	alert('keypressedddd');
	}
	else if(e.which) // IE9/Firefox/Chrome/Opera/Safari
	{
		keynum = e.which;
		if (keynum == 106)
		{
			moveLeft();	
		}	
		if (keynum == 108)
		{
			moveRight();	
		}	
		if (keynum == 105)
		{
			moveUp();	
		}	
		if (keynum == 107)
		{
			moveDown();	
		}	
		if (keynum == 32)
		{
			moveStop();	
		}	
	}
}

//submit guess
function submitGuess(button_id)
{
        guess = document.getElementById(button_id).innerHTML;
        
	checkGuess();
        
	newQuestion();
        newAnswer();
        setChoices();
        printScore();
}

function init()
{
	resetVariables();
	
	newQuestion();
	createImages('redball.gif',"question");
	newAnswer();
	setChoices();
	printScore();
}

function createButtons()
{



}


//create images
function createImages(imagesrc,appendTo)
{
	//var img = new Image();   // Create new img element
       	//img.src = imagesrc; // Set source path
	//img.id = "redball1";
        //document.getElementById(appendTo).appendChild(img);
	//img.style= "position:absolute;";
	
}

</script>

<!-- end class for game -->

<!-- creating game -->
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question -->
<p id="question"> </p>

<!-- Create Buttons (could this be done in db?) -->
        <button type="button" id="buttonMoveLeft" onclick="moveLeft(this.id)"> </button> 
        <button type="button" id="buttonMoveRight" onclick="moveRight(this.id)"> </button> 
        <button type="button" id="buttonMoveUp" onclick="moveUp(this.id)"> </button>
        <button type="button" id="buttonMoveDown" onclick="moveDown(this.id)"> </button> 
        <button type="button" id="buttonMoveStop" onclick="moveStop(this.id)"> </button> 

<!-- create images -->
<style>
DIV.movable { position:absolute; }
</style>
<div id="redball1" class="movable"><img src="redball.gif" /></div>


<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<script type="text/javascript"> init(); </script>

<script type="text/javascript"> move(); </script>

<script type="text/javascript"> document.onkeypress=moveKey </script>

</body>
</html>

