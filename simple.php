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
//game
var mGameOn = true;
var mDoorEntered = false;

//shapes
var mServerShapeArray= new Array();
var mClientShapeArray = new Array();
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
        mSpeed = 5;
}


function init()
{
        //create game   
        var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength);"; ?>

	//createWorld
	createWorld();

	//this will be used for resetting to
	resetGame();

	//tick 
	//window.setTimeout('update()',mTickLength);
	setInterval(update,20);
	//start update
	//update();
}

function update()
{	
	//move players	
	moveShapes();

	//check bounds
        checkBounds();     

	//check collisions
        checkForCollisions();
	
	//check for end game
	checkForScoreNeeded();
	
	//graphics	
	render();
       
}



function createWorld()
{
	createServerShapes();
	
	createLeftWall();
	createRightWall();
	createTopWall();
	createBottomWall();
}

function createServerShapes()
{
	//control object	
	createServerShape('smiley.png',50,50,0,0,true,false,0,true);
	
	//numbers
	createServerShape('1.png',50,50,25,0,false,true,1,true);
	createServerShape('2.png',50,50,50,0,false,true,2,true);
	createServerShape('3.png',50,50,75,0,false,true,3,true);
	createServerShape('4.png',50,50,100,0,false,true,4,true);
	createServerShape('5.png',50,50,125,0,false,true,5,true);
	createServerShape('6.png',50,50,150,0,false,true,6,true);
	createServerShape('7.png',50,50,175,0,false,true,7,true);
	createServerShape('8.png',50,50,200,0,false,true,8,true);
	createServerShape('9.png',50,50,225,0,false,true,9,true);
	createServerShape('10.png',50,50,250,0,false,true,10,true);
}

function foo()
{
	//control object	
	createServerShape('smiley.png',50,50,0,0,true,false,0,true);
	
	//numbers
	createServerShape('1.png',50,50,75,-75,false,true,1,true);
	createServerShape('2.png',50,50,75,150,false,true,2,true);
	createServerShape('3.png',50,50,300,-150,false,true,3,true);
	createServerShape('4.png',50,50,0,150,false,true,4,true);
	createServerShape('5.png',50,50,0,-250,false,true,5,true);
	createServerShape('6.png',50,50,-150,-150,false,true,6,true);
	createServerShape('7.png',50,50,300,0,false,true,7,true);
	createServerShape('8.png',50,50,150,0,false,true,8,true);
	createServerShape('9.png',50,50,-250,-150,false,true,9,true);
	createServerShape('10.png',50,50,75,250,false,true,10,true);
}

function createLeftWall()
{
	createServerShape('black_wall.png',1,50,-400,-275,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,-225,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,-175,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,-125,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,-75,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,-25,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,25,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,75,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,125,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,175,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,225,false,false,0,false);
	createServerShape('black_wall.png',1,50,-400,275,false,false,0,false);
}

function createRightWall()
{
	createServerShape('black_wall.png',1,50,400,-275,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,-225,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,-175,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,-125,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,-75,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,-25,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,25,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,75,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,125,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,175,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,225,false,false,0,false);
	createServerShape('black_wall.png',1,50,400,275,false,false,0,false);
}

function createTopWall()
{
	createServerShape('black_wall.png',50,1,-375,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-325,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-275,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-225,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-175,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-125,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-75,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-25,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,25,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,75,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,125,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,175,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,225,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,275,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,325,-300,false,false,0,false);
	createServerShape('black_wall.png',50,1,375,-300,false,false,0,false);
}

function createBottomWall()
{
	createServerShape('black_wall.png',50,1,-375,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-325,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-275,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-225,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-175,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-125,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-75,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,-25,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,25,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,75,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,125,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,175,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,225,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,275,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,325,300,false,false,0,false);
	createServerShape('black_wall.png',50,1,375,300,false,false,0,false);
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
	createClientShape(mIdCount);
	
	mIdCount++;
}

function createClientShape(i)
{
	//create the movable div that will be used to move image around.	
	var div = document.createElement('div');
        div.setAttribute('id','div' + mIdCount);
        div.setAttribute("class","movable");
	div.style.position="absolute";
	//div.style.position="absolute";
	//div.width = 20+'px';
        document.body.appendChild(div);

	//image to attache to our div "vessel"
        var image = document.createElement("IMG");
        image.id = 'image' + i;
        image.alt = 'image' + i;
        image.title = 'image' + i;   
	image.src  = mServerShapeArray[i].mSrc;
       	image.style.width=mServerShapeArray[i].mWidth+'px'; 
       	image.style.height=mServerShapeArray[i].mHeight+'px'; 
	//image.width = 20+'px';
	div.appendChild(image);
        
	div.style.visibility = 'visible';
	
	//move it
        div.style.left = mServerShapeArray[i].mPositionX+'px';
        div.style.top  = mServerShapeArray[i].mPositionY+'px';

	//add to array
	mClientShapeArray.push(div);
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
        var x1 = mControlObject.mPositionX; 
        var y1 = mControlObject.mPositionY; 
        
        for (i=0; i<mServerShapeArray.length; i++)
        {
		if (mServerShapeArray[i] == mControlObject)
		{
			//skip
		}
		else
		{
	       		if (mServerShapeArray[i].mCollidable)
                	{
                        	var x2 = mServerShapeArray[i].mPositionX;              
                     		var y2 = mServerShapeArray[i].mPositionY;              
                
                        	var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                        	if (distSQ < 650)
                        	{
					evaluateCollision(mControlObject.mId,mServerShapeArray[i].mId);		      
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
        		mClientShapeArray[i].style.left = posX+'px';
        		mClientShapeArray[i].style.top  = posY+'px';
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
                        if (posX + mServerShapeArray[i].mWidth  > $(this).width() ||
			    posY + mServerShapeArray[i].mHeight  > $(this).height())
			{
                		mClientShapeArray[i].style.left = 0+'px';
                       		mClientShapeArray[i].style.top  = 0+'px';
				mClientShapeArray[i].style.visibility = 'hidden';	
			}
			else //within dimensions...
			{
				if (mServerShapeArray[i].mCollidable || mServerShapeArray[i].mIsQuestion == 'false')
				{	
                			mClientShapeArray[i].style.left = posX+'px';
                       			mClientShapeArray[i].style.top  = posY+'px';
					mClientShapeArray[i].style.visibility = 'visible';	
				}
				else
				{
                			mClientShapeArray[i].style.left = 0+'px';
                       			mClientShapeArray[i].style.top  = 0+'px';
					mClientShapeArray[i].style.visibility = 'hidden';	
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
	}
}

function checkForDoorEntered()
{
        if (mDoorEntered)
        {
		mGameOn = false;
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
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
                mClientShapeArray[i].style.visibility = 'visible';
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
	if (mServerShapeArray[mId2].mIsQuestion)
	{
        	if (mServerShapeArray[mId2].mAnswer == mAnswer)
        	{
                	mCount = mCount + mCountBy;  //add to count
                	mScore++;
			mServerShapeArray[mId2].mCollidable = false;
			mClientShapeArray[mId2].style.visibility = 'hidden';
                
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
