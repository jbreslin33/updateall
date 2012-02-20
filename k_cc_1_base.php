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

var mViewPortX = 0;
var mViewPortY = 0;

var mSpriteX = 50;
var mSpriteY = 50;

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
//var mNumberPositionXArray = new Array(0,075,150,225,300,375,450,525,600,675,750);
//var mNumberPositionYArray = new Array(0,200,200,200,200,200,200,200,200,200,200);

var mNumberPositionXArray = new Array(0,-375,-300,-225,-150,-075,075,150,225,300,375);
var mNumberPositionYArray = new Array(0,200,200,200,200,200,200,200,200,200,200);
//var mNumberPositionXArray = new Array(0,750,600,375,300,375,075,150,225,300,375);
//var mNumberPositionYArray = new Array(0,525,300,600,150,075,675,225,750,675,375);

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

//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
	//viewport
	mViewPortX = $(this).width();
        mViewPortY = $(this).height();
	
	var xCenter = mViewPortX / 2;
	var yCenter = mViewPortY / 2;
	
	var x = 0;
	var y = 0; 
	
	//this centers avatar in view port
	x = xCenter - mSpriteX / 2; 	
	y = yCenter - mSpriteY / 2; 	
	
	//this actual moves it	
	document.getElementById("redball1").style.left = x+'px';
        document.getElementById("redball1").style.top  = y+'px';

	//move numbers
	for (i=mCount + 1;i<=mEndNumber;i++)
	{
		var xdiff = document.getElementById('number' + i).mPositionX - document.getElementById("redball1").mPositionX;	
		var ydiff = document.getElementById('number' + i).mPositionY - document.getElementById("redball1").mPositionY;	

		//center image
		x = xdiff + xCenter;
		y = ydiff + yCenter;	
		x = x - mSpriteX / 2;	
		y = y - mSpriteY / 2;	
		
		if (x + mSpriteX > mViewPortX || y + mSpriteY > mViewPortY)
		{
			document.getElementById('image' + i).style.visibility = 'hidden';
			document.getElementById('number' + i).style.left = 0+'px';
       			document.getElementById('number' + i).style.top  = 0+'px';
		}
		else
		{
			document.getElementById('image' + i).style.visibility = 'visible';
			document.getElementById('number' + i).style.left = x+'px';
       			document.getElementById('number' + i).style.top  = y+'px';
		}
	}
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
function resetGame()
{
	//delete all numbers 
        for (i=mStartNumber;i<=mEndNumber;i++)
	{
		$("#number" + i).remove();
	}
	
	//delete avatar	
	$("#redball1").remove();
	
	//create all numbers and avatar 
	createImages();

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
		document.getElementById('image' + image_id).style.visibility = 'hidden';
		
		//feedback	
                document.getElementById("feedback").innerHTML="Correct!";
		
		//check for end of game
                checkForEndOfGame();
        }
        else
        {
               	//feedback 
		document.getElementById("feedback").innerHTML="Wrong! Try again.";
	
		//this deletes and then recreates everthing.	
                resetGame();
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

function move()
{
	//move avatar
 	document.getElementById("redball1").mPositionX += document.getElementById("redball1").mVelocityX;
        document.getElementById("redball1").mPositionY += document.getElementById("redball1").mVelocityY;
     	
	//checkBounds(document.getElementById("redball1"));	
	checkCollisions();

	//move numbers
        for (i=mCount + 1;i<=mEndNumber;i++)
        {
        	document.getElementById('number' + i).mPositionX += document.getElementById('number' + i).mVelocityX;
        	document.getElementById('number' + i).mPositionY += document.getElementById('number' + i).mVelocityY;
	}
	render();

        window.setTimeout('move()',mTickLength);
}

function checkCollisions()
{
	var x1 = document.getElementById("redball1").mPositionX; 
	var y1 = document.getElementById("redball1").mPositionY; 
	
	for (i=mCount + 1;i<=mEndNumber;i++)
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
	createImages();
	resetGame();
	createButtons();	
	newQuestion();
	newAnswer();
	printScore();
	move();
}

//set buttons
function createButtons()
{
	var newdiv = document.createElement('div');
	newdiv.setAttribute("class","demo");
	document.body.appendChild(newdiv);

	var newbuttonleft = document.createElement('button');
	newbuttonleft.setAttribute('id','buttonMoveLeft');
	newdiv.appendChild(newbuttonleft);
        document.getElementById("buttonMoveLeft").onclick=moveLeftButton;
	
	var newbuttonright = document.createElement('button');
	newbuttonright.setAttribute('id','buttonMoveRight');
	newdiv.appendChild(newbuttonright);
        document.getElementById("buttonMoveRight").onclick=moveRightButton;

	var newbuttonup = document.createElement('button');
	newbuttonup.setAttribute('id','buttonMoveUp');
	newdiv.appendChild(newbuttonup);
        document.getElementById("buttonMoveUp").onclick=moveUpButton;
	
	var newbuttondown = document.createElement('button');
	newbuttondown.setAttribute('id','buttonMoveDown');
	newdiv.appendChild(newbuttondown);
        document.getElementById("buttonMoveDown").onclick=moveDownButton;
        
	var newbuttonstop = document.createElement('button');
	newbuttonstop.setAttribute('id','buttonMoveStop');
	newdiv.appendChild(newbuttonstop);
        document.getElementById("buttonMoveStop").onclick=moveStopButton;
        
	$("button").button();
        
	document.getElementById("buttonMoveLeft").innerHTML=".Left.";
	document.getElementById("buttonMoveLeft").style.position="absolute";
        document.getElementById("buttonMoveLeft").style.top="575px";
        document.getElementById("buttonMoveLeft").style.left="72px";
	
	document.getElementById("buttonMoveRight").innerHTML="Right";
        document.getElementById("buttonMoveRight").style.position="absolute";
        document.getElementById("buttonMoveRight").style.top="575px";
        document.getElementById("buttonMoveRight").style.left="237px";

	document.getElementById("buttonMoveUp").innerHTML="..Up...";
        document.getElementById("buttonMoveUp").style.position="absolute";
        document.getElementById("buttonMoveUp").style.top="535px";
        document.getElementById("buttonMoveUp").style.left="150px";

	document.getElementById("buttonMoveDown").innerHTML="Down.";
        document.getElementById("buttonMoveDown").style.position="absolute";
        document.getElementById("buttonMoveDown").style.top="615px";
        document.getElementById("buttonMoveDown").style.left="150px";

	document.getElementById("buttonMoveStop").innerHTML=".Stop.";
        document.getElementById("buttonMoveStop").style.position="absolute";
        document.getElementById("buttonMoveStop").style.top="575px";
        document.getElementById("buttonMoveStop").style.left="152px";
}

//set images
function createImages()
{
	//avatar
	var newdiv = document.createElement('div');
	newdiv.setAttribute('id','redball1');
	newdiv.setAttribute("class","movable");
	document.body.appendChild(newdiv);

	var img = document.createElement("IMG");
	img.id = 'avatar';
	document.getElementById('redball1').appendChild(img);
	document.getElementById('avatar').src  = "redball.png";

	document.getElementById("redball1").mPositionX = 0;
       	document.getElementById("redball1").mPositionY = 0;

	document.getElementById("redball1").mVelocityX = 0;
       	document.getElementById("redball1").mVelocityY = 0;

	document.getElementById("redball1").mCollidable = true;

	//numbers	
	var i = 0;
	for (i=mStartNumber;i<=mEndNumber;i++)
	{
		//create the images
		var newdiv = document.createElement('div'); 
		newdiv.setAttribute('id','number' + i); 	
		newdiv.setAttribute("class","movable"); 
		document.body.appendChild(newdiv); 	
	
		var img = document.createElement("IMG");
		img.id = 'image' + i;	
		document.getElementById('number' + i).appendChild(img);
	
		document.getElementById('image' + i).src  = i + ".png";
		
                document.getElementById('number' + i).mPositionX = mNumberPositionXArray[i];
                document.getElementById('number' + i).mPositionY = mNumberPositionYArray[i];

		document.getElementById('number' + i).mVelocityX = 0;
        	document.getElementById('number' + i).mVelocityY = 0;
		
        	document.getElementById('number' + i).mCollidable = true;
		document.getElementById('number' + i).mID = i;
		document.getElementById('number' + i).mAnswer = i;
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

<script type="text/javascript"> 

$(document).ready(function()
{
	init();
}
);

</script>

</body>
</html>

