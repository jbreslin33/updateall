<html>
<head>

<title>Image Mover</title>

<!-- jquery and jqueryui -->
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>

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

<script language="javascript">

//GLOBALS
var mSpriteArray= new Array();

//players
var mPlayerArray = new Array();
var mControlObject;

//score
var mScoreNeeded = 0;
var mScore = 0;

//count
var mCountBy = 0;
var mCount = 0;
var mStartNumber = 0;
var mEndNumber = 0;

//ticks
var mTickLength = 0;

//questions
var mQuestion = 0;
var mAnswer = 0;

// id counter
var mIdCount = 0;

function Game(scoreNeeded, countBy, startNumber, endNumber, tickLength)
{
        //players

        //score
        mScoreNeeded = scoreNeeded;

        //count
        mCountBy = countBy;
        mStartNumber = startNumber;
        mEndNumber = endNumber; 

        //ticks
        mTickLength = tickLength;

        //speed
        mSpeed = 3;
}


function init()
{
        //create game   
        var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength);"; ?>

	//createWorld
	createWorld();

	//this will be used for resetting to
	resetGame();

	//start update
	update();
}

function update()
{	
	//move players	
	movePlayers();

	//check bounds
        //checkBounds(document.getElementById("redball1"));     

	//check collisions
        checkCollisions();
		
	//graphics	
	render();
       
	//tick 
	window.setTimeout('update()',mTickLength);
}



function createWorld()
{

	createSprite('smiley.png',0,0,true,0,true);

	//create all players
	createSprite('1.png',75,75,false,1,true);
	createSprite('2.png',75,150,false,2,true);
	createSprite('3.png',300,450,false,3,true);
	createSprite('4.png',0,150,false,4,true);
	createSprite('5.png',0,300,false,5,true);
	createSprite('6.png',150,150,false,6,true);
	createSprite('7.png',300,0,false,7,true);
	createSprite('8.png',150,0,false,8,true);
	createSprite('9.png',450,150,false,9,true);
	createSprite('10.png',75,300,false,10,true);
		
        for (i=0; i<mSpriteArray.length; i++)
	{
		createPlayer(i);
	}
}

function createSprite(src,spawnX,spawnY,isControlObject,answer,collidable)
{
	var sprite = new Object();
	sprite.mSrc = src;
	sprite.mId = mIdCount;
	sprite.mSpawnPositionX = spawnX;
	sprite.mSpawnPositionY = spawnY;
	sprite.mPositionX = spawnX;
	sprite.mPositionY = spawnY;
	sprite.mVelocityX = 0;
	sprite.mVelocityY = 0;
	sprite.mCollidable = collidable;
	sprite.mAnswer = answer;
	 
	if (isControlObject)
	{
		mControlObject = sprite;
	}
	
	mIdCount++;
	
	//add to array
	mSpriteArray.push(sprite);
}

function createPlayer(i)
{
	
	//create the movable div that will be used to move image around.	
	var div = document.createElement('div');
        div.setAttribute('id','div' + mIdCount);
        div.setAttribute("class","movable");
	div.style.position="absolute";
        document.body.appendChild(div);

	//image to attache to our div "vessel"
        var image = document.createElement("IMG");
        image.id = 'image' + i;
        //image.alt = 'image' + i;
        //image.title = 'image' + i;   
        div.appendChild(image);
        
	image.src  = mSpriteArray[i].mSrc;

	//move it
        div.style.left = mSpriteArray[i].mPositionX+'px';
        div.style.top  = mSpriteArray[i].mPositionY+'px';

	//add to array
	mPlayerArray.push(div);

}


function movePlayers()
{
        //move numbers
        for (i=0; i<mSpriteArray.length; i++)
        {
		mSpriteArray[i].mPositionX += mSpriteArray[i].mVelocityX;
		mSpriteArray[i].mPositionY += mSpriteArray[i].mVelocityY;
        }
}

function checkCollisions()
{
        var x1 = mControlObject.mPositionX; 
        var y1 = mControlObject.mPositionY; 
        
        for (i=0; i<mSpriteArray.length; i++)
        {
		if (mSpriteArray[i] == mControlObject)
		{
			//skip
		}
		else
		{
	       		if (mSpriteArray[i].mCollidable)
                	{
                        	var x2 = mSpriteArray[i].mPositionX;              
                     		var y2 = mSpriteArray[i].mPositionY;              
                
                        	var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                        	if (distSQ < 1300)
                        	{
        				checkGuess(i);
        
        				newQuestion();
        				newAnswer();
        				printScore();
                        	}
			}
                }       
        }
}



//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
        //loop thru player array and update their xy positions
        for (i=0; i<mSpriteArray.length; i++)
        {
		//get the center of the page xy
       		var pageCenterX = $(this).width() / 2;
        	var pageCenterY = $(this).height() / 2;
      
       		//get the center xy of the image
       		var imageCenterX = $("#image" + i).width() / 2;     
       		var imageCenterY = $("#image" + i).height() / 2;     

		//if control object center it on screen
		if (mSpriteArray[i] == mControlObject)
		{
			//shift the position based on pageCenterXY and imageCenterXY	
        		var posX = pageCenterX - imageCenterX;     
        		var posY = pageCenterY - imageCenterY;     
			
			//this actual moves it  
        		mPlayerArray[i].style.left = posX+'px';
        		mPlayerArray[i].style.top  = posY+'px';
		} 
		//else if anything else render relative to the control object	
		else
		{
			//get the offset from control object
			var xdiff = mSpriteArray[i].mPositionX - mControlObject.mPositionX;  
                	var ydiff = mSpriteArray[i].mPositionY - mControlObject.mPositionY;  

                	//center image relative to position
                	var posX = xdiff + pageCenterX - imageCenterX;
                	var posY = ydiff + pageCenterY - imageCenterY;    
               
                	mPlayerArray[i].style.left = posX+'px';
                       	mPlayerArray[i].style.top  = posY+'px';
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
//count

 //set collidable to true 
        for (i=0; i<mPlayerArray.length; i++)
        {
                mSpriteArray[i].mCollidable = true;
                //mPlayerArray[i].style.visibility = 'visible';
        }
	mControlObject.mPositionX = 0;     
	mControlObject.mPositionY = 0;     
 
        //score
        mScore = 0;

        //game
        mQuestion = "";

        //count
        mCount = mStartNumber - 1;
        
var mAnswer = 0;
	//answer
	newAnswer();
}

//check guess
function checkGuess(index)
{
        if (mSpriteArray[index].mAnswer == mAnswer)
        {
                mCount = mCount + mCountBy;  //add to count
                mScore++;
               
		mSpriteArray[index].mCollidable = false;
                //mSpriteArray[index].style.visibility = 'hidden';
                
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

//CONTROLS
function moveLeft()
{
        mControlObject.mVelocityX = -1 * mSpeed;
        mControlObject.mVelocityY = 0;
}

function moveRight()
{
        mControlObject.mVelocityX = 1 * mSpeed;
        mControlObject.mVelocityY = 0;
}

function moveUp()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = -1 * mSpeed;
}

function moveDown()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = 1 * mSpeed;
}

function moveStop()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = 0;
}

document.onkeydown = function(ev) 
{
        var keynum;
        ev = ev || event;
        keynum = ev.keyCode;

        if (keynum == 37)
        {
                moveLeft();  
        }       
        if (keynum == 39)
        {
                moveRight(); 
        }       
        if (keynum == 38)
        {
                moveUp();    
        }       
        if (keynum == 40)
        {
                moveDown();  
        }       
        if (keynum == 32)
        {
                moveStop();  
        }       
}

</script>

</head>
<body>
<script type="text/javascript"> 

$(document).ready(function()
{
        init();
}
);

</script>

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

</body>
</html>
