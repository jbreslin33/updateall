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

var mViewPortXOptimal = 1280;
var mViewPortYOptimal = 1024;
var mViewPortXActual = 0;
var mViewPortYActual = 0;
var mViewPortXScale = 0.0;
var mViewPortYScale = 0.0;

var mSpriteXOptimal = 50;
var mSpriteYOptimal = 50;
var mSpriteXActual = 0;
var mSpriteYActual = 0;
var mSpriteXScale = 0.0;
var mSpriteYScale = 0.0;

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


//ball positions
var mNumberPositionXArray = new Array(0,75,150,225,300,375,450,525,600,675,750);
var mNumberPositionYArray = new Array(0,200,200,200,200,200,200,200,200,200,200);


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

function resize_image(image, w, h) {

    if (typeof(image) != 'object') image = document.getElementById(image);

    if (w == null || w == undefined)
        w = (h / image.clientHeight) * image.clientWidth;

    if (h == null || h == undefined)
        h = (w / image.clientWidth) * image.clientHeight;

    image.style['height'] = h + 'px';
    image.style['width'] = w + 'px';
    return;
}

//Score
function printScore()
{
        document.getElementById("score").innerHTML="Score: " + mScore;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + mScoreNeeded;
}

function checkForEndOfGame()
{
        if (mScore == mScoreNeeded)
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
        mCount = mStartNumber - 1;
	
	//move avatar to start
	document.getElementById("redball1").mPositionX = 0;
        document.getElementById("redball1").mPositionY = 0;
	
	//make images and numbers visible and collidable
        for (i=mStartNumber;i<=mEndNumber;i++)
	{
		document.getElementById('number' + i).style.visibility = 'visible'; 
		document.getElementById('number' + i).mCollidable = true; 
	}
}

//check guess
function checkGuess(image_id)
{
        if (mGuess == mAnswer)
        {
                mCount = mCount + mCountBy;  //add to count
                mScore++;

		//made image disapper and make collibal false
		document.getElementById('number' + image_id).mCollidable = false;
		document.getElementById('number' + image_id).style.visibility = 'hidden';
		
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

//new answer
function newAnswer()
{
        mAnswer = mCount + mCountBy;
}

//set buttons
function setButtons()
{
	$("button").button();
	
	document.getElementById("buttonMoveLeft").style.position="absolute";
	document.getElementById("buttonMoveLeft").style.top="575px";
	document.getElementById("buttonMoveLeft").style.left="72px";

	document.getElementById("buttonMoveRight").style.position="absolute";
	document.getElementById("buttonMoveRight").style.top="575px";
	document.getElementById("buttonMoveRight").style.left="237px";


	document.getElementById("buttonMoveUp").style.position="absolute";
	document.getElementById("buttonMoveUp").style.top="535px";
	document.getElementById("buttonMoveUp").style.left="150px";

	document.getElementById("buttonMoveDown").style.position="absolute";
	document.getElementById("buttonMoveDown").style.top="615px";
	document.getElementById("buttonMoveDown").style.left="150px";

	document.getElementById("buttonMoveStop").style.position="absolute";
	document.getElementById("buttonMoveStop").style.top="575px";
	document.getElementById("buttonMoveStop").style.left="152px";
}

function move()
{
	//move avatar
 	document.getElementById("redball1").mPositionX += document.getElementById("redball1").mVelocityX;
        document.getElementById("redball1").mPositionY += document.getElementById("redball1").mVelocityY;
     	
	//checkBounds(document.getElementById("redball1"));	
	checkCollisions();

	//move numbers
        for (i=mStartNumber;i<=mEndNumber;i++)
        {
        	document.getElementById('number' + i).mPositionX += document.getElementById('number' + i).mVelocityX;
        	document.getElementById('number' + i).mPositionY += document.getElementById('number' + i).mVelocityY;
	}
	render();

        window.setTimeout('move()',mTickLength);
}
//render- let's pretend on "server" that field is 1280x1060 then we simply still move x spaces per move but
//render handles the client drawing...or only render what is in the viewport no matter the size then you
//don't need to worry about anything. player is always located center...
//to do this do you need to render everything relative to player?
//or 
function render()
{

	//check scales
	mViewPortXActual = $(this).width();
        mViewPortYActual = $(this).height();

        var mViewPortXScale = mViewPortXActual / mViewPortXOptimal;
        var mViewPortYScale = mViewPortYActual / mViewPortYOptimal;
        
        var mSpriteXScale = mSpriteXOptimal * mViewPortXScale;
        var mSpriteYScale = mSpriteYActual / mSpriteYOptimal;
        
        document.getElementById("dimensions").innerHTML="mViewPortXActual: " + mViewPortXActual + " mViewPortYActual: " + mViewPortYActual + "mViewPortXScale: " + mViewPortXScale + " mViewPortYScale " + mViewPortYScale;     
	var x = 0; var y = 0;

	//resize_image(document.getElementById("image6"),xmod,ymod);
	//must figure out where to draw avatar...
//	mSpriteXScalekh
	//move avatar	
       	x = document.getElementById("redball1").mPositionX - mSpriteXScale / 2;
     	y = document.getElementById("redball1").mPositionY - mSpriteYScale / 2;
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

function checkCollisions()
{
	var x1 = document.getElementById("redball1").mPositionX; 
	var y1 = document.getElementById("redball1").mPositionY; 
	
	for (i=mStartNumber;i<=mEndNumber;i++)
	{
		if (document.getElementById('number' + i).mCollidable)
		{
			var x2 = document.getElementById('number' + i).mPositionX;		
			var y2 = document.getElementById('number' + i).mPositionY;		
		
			var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
			if (distSQ < 1300)
			{
				submitGuess(document.getElementById('number' + i).mID);	
			}
		}	
	}
}

function checkBounds(thing)
{
        if (thing.mPositionX < 25)
        {
                thing.mPositionX = 25;
        }
        if (thing.mPositionX > 600)
        {
                thing.mPositionX = 600;
        }
        if (thing.mPositionY < 25)
        {
                thing.mPositionY = 25;
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

function moveLeftButton()
{
	moveLeft(document.getElementById("redball1"));
}

function moveRight(thing)
{
	thing.mVelocityX = 1;
        thing.mVelocityY = 0;
}

function moveRightButton()
{
	moveRight(document.getElementById("redball1"));
}

function moveUp(thing)
{
       	thing.mVelocityX = 0;
	thing.mVelocityY = -1;
}

function moveUpButton()
{
	moveUp(document.getElementById("redball1"));
}

function moveDown(thing)
{
        thing.mVelocityX = 0;
	thing.mVelocityY = 1;
}

function moveDownButton()
{
	moveDown(document.getElementById("redball1"));
}

function moveStop(thing)
{
        thing.mVelocityX = 0;
        thing.mVelocityY = 0;
}

function moveStopButton()
{
	moveStop(document.getElementById("redball1"));
}

document.onkeydown = function(ev) 
{
	var keynum;
	ev = ev || event;
	keynum = ev.keyCode;

	if (keynum == 37)
	{
		moveLeft(document.getElementById("redball1"));	
	}	
	if (keynum == 39)
	{
		moveRight(document.getElementById("redball1"));	
	}	
	if (keynum == 38)
	{
		moveUp(document.getElementById("redball1"));	
	}	
	if (keynum == 40)
	{
		moveDown(document.getElementById("redball1"));	
	}	
	if (keynum == 32)
	{
		moveStop(document.getElementById("redball1"));	
	}	
}

$(window).resize(function() {
});

function resizeAll() 
{

}

//submit guess
function submitGuess(image_id)
{
        mGuess = image_id;
        
	checkGuess(image_id);
        
	newQuestion();
        newAnswer();
        printScore();
}

function init()
{
	resetVariables();
	setButtons();	
	newQuestion();
	setImages();
	newAnswer();
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
		
                document.getElementById('number' + i).mPositionX = mNumberPositionXArray[i];
                document.getElementById('number' + i).mPositionY = mNumberPositionYArray[i];

		document.getElementById('number' + i).mVelocityX = 0;
        	document.getElementById('number' + i).mVelocityY = 0;
		
        	document.getElementById('number' + i).mCollidable = true;
		document.getElementById('number' + i).mID = i;
		document.getElementById('number' + i).mAnswer = i;
			
	
		offset = offset + 60;
	}  
	render();
}

</script>

<!-- end class for game -->

<!-- creating game -->
<script type="text/javascript">  var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength);"; ?> </script>

<!-- create images -->
<style>
DIV.movable { position:absolute; }
</style>

<!-- boundry 
<div id="boundry" class="movable"><img src="boundry.png" /></div>
-->

<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question -->
<p id="question"> </p>


<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<!-- create dimensions -->
<p id="dimensions"></p>

<div class="demo">

<!-- Create Buttons (could this be done in db?) -->
       	<button type="button" id="buttonMoveLeft" onclick="moveLeftButton()"> .Left. </button> 
        <button type="button" id="buttonMoveRight" onclick="moveRightButton()"> Right </button> 
        <button type="button" id="buttonMoveUp" onclick="moveUpButton()"> ..Up... </button>
        <button type="button" id="buttonMoveDown" onclick="moveDownButton()"> Down. </button> 
        <button type="button" id="buttonMoveStop" onclick="moveStopButton()"> .Stop. </button> 

</div><!-- End demo -->


<div id="redball1" class="movable"><img src="redball.png" /></div>

<?php
	for ($i=$startNumber; $i<=$scoreNeeded; $i++)
	{
		echo "<div id=\"number$i\" class=\"movable\"><img id=\"image$i\" /></div>";
	}
?>

<script type="text/javascript"> 

$(document).ready(function()
{
	init();
}
);

</script>

</body>
</html>

