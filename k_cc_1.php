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
$query = "select name, score_needed, count_by, start_number, end_number, tick_length from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$scoreNeeded = 0;
$countBy = 0;
$startNumber = 0;
$endNumber = 0;
$tickLength = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $name = $row[0];
        $scoreNeeded = $row[1];
        $countBy = $row[2];
        $startNumber = $row[3];
	$endNumber = $row[4];
	$tickLength = $row[5];
}

?>

<!-- class for game -->
<script type="text/javascript">

var mStartNumber = 0;
var mEndNumber = 0;
var mScoreNeeded = 0;
var mScore = 0;
var mQuestion = 0;
var mGuess = 0;
var mAnswer = 0;
var mCountBy = 0;
var mCount = 0;
var mTickLength = 0;

function Game(scoreNeeded, countBy, startNumber, endNumber, tickLength)
{
	//score
	mScoreNeeded = scoreNeeded;

	//count
	mCountBy = countBy;
	mStartNumber = startNumber;
	mEndNumber = endNumber;	

	//ticks
	mTickLength = tickLength;
}


//Score
function printScore()
{
        document.getElementById("score").innerHTML="Score: " + mScore;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + mScoreNeeded;
}

function checkForEndOfGame()
{
        if (mScore == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

//reset
function resetVariables()
{
	//score
	mScore = 0;

	//game
        mQuestion = "";
        mGuess = 0;
        mAnswer = 0;

	//count
        mCount = mStartNumber;
}

//check guess
function checkGuess()
{
        if (mGuess == mAnswer)
        {
                mCount = mCount + mCountBy;  //add to count
                mScore++;

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
        mQuestion = mQuestion + ' ' + mCount;
        document.getElementById("question").innerHTML=mQuestion;
}

//set choices
function setChoices()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = mAnswer - offset;
        setButtons(offset);
}

//new answer
function newAnswer()
{
        mAnswer = mCount + mCountBy;
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



function move()
{
	//move avatar
 	document.getElementById("redball1").mPositionX += document.getElementById("redball1").mVelocityX;
        document.getElementById("redball1").mPositionY += document.getElementById("redball1").mVelocityY;
     	
	checkBounds(document.getElementById("redball1"));	

	//move numbers
        for (i=mStartNumber;i<=mEndNumber;i++)
        {
        	document.getElementById('number' + i).mPositionX += document.getElementById('number' + i).mVelocityX;
        	document.getElementById('number' + i).mPositionY += document.getElementById('number' + i).mVelocityY;
	}
	render();

        window.setTimeout('move()',mTickLength);
}

function render()
{
	var x = 0;
	var y = 0;

	//move avatar	
       	x = document.getElementById("redball1").mPositionX - 25;
     	y = document.getElementById("redball1").mPositionY - 25;
	document.getElementById("redball1").style.left = x+'px';
        document.getElementById("redball1").style.top  = y+'px';

	//move numbers
	for (i=mStartNumber;i<=mEndNumber;i++)
	{
        	x = document.getElementById('number' + i).mPositionX - 25;
              	y = document.getElementById('number' + i).mPositionY - 25;
	
		document.getElementById('number' + i).style.left = x+'px';
        	document.getElementById('number' + i).style.top  = y+'px';
	}
}

function checkBounds(thing)
{
        if (thing.mPositionX < 0)
        {
                thing.mPositionX = 0;
        }
        if (thing.mPositionX > 600)
        {
                thing.mPositionX = 600;
        }
        if (thing.mPositionY < 0)
        {
                thing.mPositionY = 0;
        }
        if (thing.mPositionY > 600)
        {
                thing.mPositionY = 600;
        }
}

function moveLeft(thing)
{
	thing.mVelocityX = -1;
        thing.mVelocityY = 0;
}

function moveRight(thing)
{
	thing.mVelocityX = 1;
        thing.mVelocityY = 0;
}

function moveUp(thing)
{
       	thing.mVelocityX = 0;
	thing.mVelocityY = -1;
}

function moveDown(thing)
{
        thing.mVelocityX = 0;
	thing.mVelocityY = 1;
}

function moveStop(thing)
{
        thing.mVelocityX = 0;
        thing.mVelocityY = 0;
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
			moveLeft(document.getElementById("redball1"));	
		}	
		if (keynum == 108)
		{
			moveRight(document.getElementById("redball1"));	
		}	
		if (keynum == 105)
		{
			moveUp(document.getElementById("redball1"));	
		}	
		if (keynum == 107)
		{
			moveDown(document.getElementById("redball1"));	
		}	
		if (keynum == 32)
		{
			moveStop(document.getElementById("redball1"));	
		}	
	}
}

//submit guess
function submitGuess(button_id)
{
        mGuess = document.getElementById(button_id).innerHTML;
        
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
	setImages();
	newAnswer();
	setChoices();
	printScore();
	move();
}

//set images
function setImages()
{
	
	//avatar
	document.getElementById("redball1").mPositionX = 0;
       	document.getElementById("redball1").mPositionY = 0;

	document.getElementById("redball1").mVelocityX = 0;
       	document.getElementById("redball1").mVelocityY = 0;

	document.getElementById("redball1").mCollidable = true;

	//numbers	
	var i = 0;
	var offset = 60;
	for (i=mStartNumber;i<=mEndNumber;i++)
	{
		document.getElementById('image' + i).src  = i + ".png";
		
		document.getElementById('number' + i).mPositionX = offset;
        	document.getElementById('number' + i).mPositionY = offset;

		document.getElementById('number' + i).mVelocityX = 0;
        	document.getElementById('number' + i).mVelocityY = 0;
		
        	document.getElementById('number' + i).mCollidable = true;
		
	
		offset = offset + 60;
	}  
	render();
}

</script>

<!-- end class for game -->

<!-- creating game -->
<script type="text/javascript">  var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength);"; ?> </script>

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

<?php

	for ($i=$startNumber; $i<=$scoreNeeded; $i++)
	{
		echo "<div id=\"number$i\" class=\"movable\"><img id=\"image$i\" /></div>";
	}

?>


<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>


<script type="text/javascript"> 
$(document).ready(function(){
 // $("button").click(function(){
    //$(".test").hide();
	init();
//  });
});
</script>

<script type="text/javascript"> document.onkeypress=moveKey </script>

</body>
</html>

