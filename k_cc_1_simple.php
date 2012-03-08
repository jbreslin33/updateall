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
$query = "select name, score_needed, count_by, start_number, end_number, tick_length, next_level, number_of_chasers, speed from math_games where level = ";
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
$nextLevel = 0;
$numberOfChasers = 0;
$speed = 0;

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
	$nextLevel = $row[6];
	$numberOfChasers = $row[7];
	$speed = $row[8];
	$_SESSION["math_game_next_level"] = $nextLevel;
}

?>

<script language="javascript">

//GLOBALS
//game
var mGameOn = true;
var mDoorEntered = false;

//shapes
var mServerShapeArray = new Array();
var mClientDivArray = new Array();
var mClientShapeArray = new Array();

var mPositionXArray = new Array();
var mPositionYArray = new Array();

var mSlotPositionXArray = new Array();
var mSlotPositionYArray = new Array();

var proposedX = 0;
var proposedY = 0;

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

//chasers
var mNumberOfChasers = 0;

function Game(scoreNeeded, countBy, startNumber, endNumber, tickLength, numberOfChasers, speed)
{
        //score
        mScoreNeeded = scoreNeeded;

        //count
        mCountBy = countBy;
        mStartNumber = startNumber;
        mEndNumber = endNumber; 

        //ticks
        mTickLength = tickLength;

        //speed
        mSpeed = speed;
	
	//chasers
	mNumberOfChasers = numberOfChasers;
}

function init()
{
        //create game   
        var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength, $numberOfChasers, $speed);"; ?>

	//createWorld
	createWorld();

	//this will be used for resetting to
	resetGame();

	//start update
	setInterval(update,mTickLength);
}

function update()
{	
	if (mGameOn)
	{	
		//move players	
		moveShapes();

		//door entered?
		checkForDoorEntered();

		//check bounds
        	checkBounds();     

		//check collisions
        	checkForCollisions();
	
		//check for end game
		checkForScoreNeeded();
		
		//graphics	
		render();
      	} 
}



function createWorld()
{
	fillSpawnPositionArrays();
	createServerShapes();
	
	createLeftWall();
	createRightWall();
	createTopWall();
	createBottomWall();
}

function createServerShapes()
{
	//control object	
	createServerShape('smiley.png',50,50,0,0,true,false,"",true);
	
	for (i = 0; i <= 9; i++)
	{
		setUniqueSpawnPosition();
		createServerShape("",50,50,mPositionXArray[proposedX],mPositionYArray[proposedY],false,true,mStartNumber + i,true);
	}

	for (i = 0; i < mNumberOfChasers; i++)
	{
		setUniqueSpawnPosition();
		createServerShape('redball.gif',50,50,mPositionXArray[proposedX],mPositionYArray[proposedY],false,true,"chaser",true);
	}
}

function setUniqueSpawnPosition()
{
	//get random spawn element
	proposedX = Math.floor(Math.random()*mPositionXArray.length);
	proposedY = Math.floor(Math.random()*mPositionYArray.length);

	for (r= 0; r < mServerShapeArray.length; r++)
	{
		if (proposedX == mServerShapeArray[r].mPositionX && proposedY == mServerShapeArray[r].mPositionY)	
		{
			r = 0;
			proposedX = Math.floor(Math.random()*mPositionXArray.length);
			proposedY = Math.floor(Math.random()*mPositionYArray.length);
		}
	}
}

function fillSpawnPositionArrays()
{
	for (i=-375; i <= 375; i = i + 50)
	{ 	
		mPositionXArray.push(i);	
	}
	
	for (i=-275; i <= 275; i = i + 50)
	{ 	
		mPositionYArray.push(i);	
	}
}

function createServerShape(src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable)
{
	var shape = new Object();
	shape.mSrc = src;
	shape.mId = mIdCount;
		
	shape.mSpawnPositionX = spawnX;
	shape.mSpawnPositionY = spawnY;
	shape.mWidth = width;
	shape.mHeight = height;
	shape.mPositionX = spawnX;
	shape.mPositionY = spawnY;
	shape.mOldPositionX = spawnX;
	shape.mOldPositionY = spawnY;
	shape.mVelocityX = 0;
	shape.mVelocityY = 0;
	shape.mCollidable = collidable;
	shape.mIsQuestion = isQuestion;
	shape.mAnswer = answer;
	 
	if (isControlObject)
	{
		mControlObject = shape;
	}
	
	//add to array
	mServerShapeArray.push(shape);
	
	//create clientside shape, this would send across network...
	createClientDiv(mIdCount);
	
	mIdCount++;
}

function createClientDiv(i)
{
	//create the movable div that will be used to move image around.	
	var div = document.createElement('div');
        div.setAttribute('id','div' + mIdCount);
        div.setAttribute("class","demo");
	div.style.position="absolute";
	div.style.visibility = 'visible';
	
	div.style.width= mServerShapeArray[i].mWidth;
	div.style.height= mServerShapeArray[i].mHeight;
	
	//move it
        div.style.left = mServerShapeArray[i].mPositionX+'px';
        div.style.top  = mServerShapeArray[i].mPositionY+'px';

        document.body.appendChild(div);
	
	div.style.backgroundColor = "yellow";
	
	//add div to array
	mClientDivArray.push(div);

	//create clientImage
	if (mServerShapeArray[i].mSrc)
	{
		createClientImage(i);
	}
	else //create paragraph
	{
		createClientParagraph(i);
	}
	//back to div	
	div.appendChild(mClientShapeArray[i]);
}

function createClientImage(i)
{
        //image to attache to our div "vessel"
        var image = document.createElement("IMG");
        image.id = 'image' + i;
        image.alt = 'image' + i;
        image.title = 'image' + i;   
        image.src  = mServerShapeArray[i].mSrc;
        image.style.width=mServerShapeArray[i].mWidth+'px'; 
        image.style.height=mServerShapeArray[i].mHeight+'px'; 

        //add image to array
        mClientShapeArray.push(image);
}

function createClientParagraph(i)
{
	var paragraph = document.createElement("p");
	paragraph.innerHTML = mServerShapeArray[i].mAnswer;

	mClientShapeArray.push(paragraph);
}

function createClientButton(i)
{
	var button = document.createElement("button");
	button.innerHTML = mServerShapeArray[i].mAnswer;

	mClientShapeArray.push(button);
}

function createLeftWall()
{
        for (i=-275; i <= 275; i = i + 50)
	{
		createServerShape('black_wall.png',1,50,-400,i,false,false,"",false);
	}
}

function createRightWall()
{
        for (i=-275; i <= 275; i = i + 50)
	{
		if (i == 25 || i == -25)
		{
			createServerShape('green_wall.png',1,50,400,i,false,false,"",false);
		}	
		else
		{	
			createServerShape('black_wall.png',1,50,400,i,false,false,"",false);
		}
	}
}

function createTopWall()
{
        for (i=-375; i <= 375; i = i + 50)
	{
		createServerShape('black_wall.png',50,1,i,-300,false,false,"",false);
	}
}

function createBottomWall()
{
        for (i=-375; i <= 375; i = i + 50)
	{
		createServerShape('black_wall.png',50,1,i,300,false,false,"",false);
	}
}

function moveShapes()
{
        //move numbers
        for (i=0; i<mServerShapeArray.length; i++)
        {
		//record old position to use for collisions or whatever you fancy	
		mServerShapeArray[i].mOldPositionX = mServerShapeArray[i].mPositionX;
		mServerShapeArray[i].mOldPositionY = mServerShapeArray[i].mPositionY;
	
		//move shape	
		mServerShapeArray[i].mPositionX += mServerShapeArray[i].mVelocityX;
		mServerShapeArray[i].mPositionY += mServerShapeArray[i].mVelocityY;
        }
}

function checkBounds()
{
	if (mControlObject.mPositionX < -400 ||	
	    mControlObject.mPositionX > 400 ||
	    mControlObject.mPositionY < -300 ||
	    mControlObject.mPositionY > 300)
	{
		mControlObject.mPositionX = mControlObject.mPositionX;	
		mControlObject.mPositionY = mControlObject.mPositionY;	
	}
	
}

function checkForCollisions()
{

	for (s=0; s < mServerShapeArray.length; s++)
	{
	       	var x1 = mServerShapeArray[s].mPositionX;
	       	var y1 = mServerShapeArray[s].mPositionY;
 
		for (i=0; i<mServerShapeArray.length; i++)
       		{
			if (mServerShapeArray[i] == mServerShapeArray[s])
			{
				//skip
			}
			else
			{
				if (mServerShapeArray[i].mCollidable == true && mServerShapeArray[s].mCollidable == true)
                		{
                        		var x2 = mServerShapeArray[i].mPositionX;              
                     			var y2 = mServerShapeArray[i].mPositionY;              
                
                        		var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                        		if (distSQ < 650)
                        		{
						evaluateCollision(mServerShapeArray[s].mId,mServerShapeArray[i].mId);		      
                        		}
				}
                	}       
        	}
	}

}

//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
        //loop thru player array and update their xy positions
        for (i=0; i<mServerShapeArray.length; i++)
        {
		//get the center of the page xy
       		var pageCenterX = $(this).width() / 2;
        	var pageCenterY = $(this).height() / 2;
      
       		//get the center xy of the image
       		var imageCenterX = mServerShapeArray[i].mWidth / 2;     
       		var imageCenterY = mServerShapeArray[i].mHeight / 2;     
       		//var imageCenterY = $("#image" + i).height() / 2;     

		//if control object center it on screen
		if (mServerShapeArray[i] == mControlObject)
		{
			//shift the position based on pageCenterXY and imageCenterXY	
        		var posX = pageCenterX - imageCenterX;     
        		var posY = pageCenterY - imageCenterY;     
			
			//this actual moves it  
        		mClientDivArray[i].style.left = posX+'px';
        		mClientDivArray[i].style.top  = posY+'px';
		} 
		//else if anything else render relative to the control object	
		else
		{
			//get the offset from control object
			var xdiff = mServerShapeArray[i].mPositionX - mControlObject.mPositionX;  
                	var ydiff = mServerShapeArray[i].mPositionY - mControlObject.mPositionY;  

                	//center image relative to position
                	var posX = xdiff + pageCenterX - imageCenterX;
                	var posY = ydiff + pageCenterY - imageCenterY;    
			
			//if off screen then hide it so we don't have scroll bars mucking up controls 
                        if (posX + mServerShapeArray[i].mWidth  + 3 > $(this).width() ||
			    posY + mServerShapeArray[i].mHeight + 13 > $(this).height())
			{
                		mClientDivArray[i].style.left = 0+'px';
                       		mClientDivArray[i].style.top  = 0+'px';
				mClientDivArray[i].style.visibility = 'hidden';	
			}
			else //within dimensions..and still collidable(meaning a number that has been answered) or not a question at all
			{
				if (mServerShapeArray[i].mCollidable || 
				    mServerShapeArray[i].mIsQuestion == 'false')
				{	
                			mClientDivArray[i].style.left = posX+'px';
                       			mClientDivArray[i].style.top  = posY+'px';
					mClientDivArray[i].style.visibility = 'visible';	
				}
				else
				{
                			mClientDivArray[i].style.left = 0+'px';
                       			mClientDivArray[i].style.top  = 0+'px';
					mClientDivArray[i].style.visibility = 'hidden';	
				}
			}
		}
        }
}

//Score
function printScore()
{
        document.getElementById("score").innerHTML="Score: " + mScore;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + mScoreNeeded;
}

function checkForScoreNeeded()
{
        if (mScore == mScoreNeeded)
        {
		//open the doors
		for (i=0; i < mServerShapeArray.length; i++)
		{
			if (mServerShapeArray[i].mSrc == 'green_wall.png')
			{
				mServerShapeArray[i].mSrc = 'white_wall.png';
				mClientShapeArray[i].src = 'white_wall.png';
			}
		}
	}
}

function checkForDoorEntered()
{
        //if (mDoorEntered)
        if (mScore == mScoreNeeded)
        {
		if (mControlObject.mPositionX > 375 &&
		    mControlObject.mPositionY > -25 &&
		    mControlObject.mPositionY < 25) 
		    	
		{
			mGameOn = false;
                	document.getElementById("feedback").innerHTML="YOU WIN!!!";
                	window.location = "goto_next_math_level.php"
		}
        }
}

//reset
function resetGame()
{
//count

 //set collidable to true 
        for (i=0; i<mServerShapeArray.length; i++)
        {
                mServerShapeArray[i].mCollidable = true;
                mClientDivArray[i].style.visibility = 'visible';
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
function evaluateCollision(mId1,mId2)
{
	if (mServerShapeArray[mId1] == mControlObject)
	{

		if (mServerShapeArray[mId2].mIsQuestion)
		{
        		if (mServerShapeArray[mId2].mAnswer == mAnswer)
        		{
                		mCount = mCount + mCountBy;  //add to count
                		mScore++;
				mServerShapeArray[mId2].mCollidable = false;
				mClientDivArray[mId2].style.visibility = 'hidden';
                
                		//feedback      
                		document.getElementById("feedback").innerHTML="Correct!";
        		}
        		else
        		{
                		//feedback 
                		document.getElementById("feedback").innerHTML="Wrong! Try again.";
        
                		//this deletes and then recreates everthing.    
                		resetGame();
        		}
    			newQuestion();
        		newAnswer();
        		printScore();
		}
		else
		{
			mServerShapeArray[mId1].mPositionX = mServerShapeArray[mId1].mOldPositionX;
			mServerShapeArray[mId1].mPositionY = mServerShapeArray[mId1].mOldPositionY;
		
			mServerShapeArray[mId2].mPositionX = mServerShapeArray[mId2].mOldPositionX;
			mServerShapeArray[mId2].mPositionY = mServerShapeArray[mId2].mOldPositionY;
		}
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
