<html>
<head>

	<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 200px; }
	#sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
	html>body #sortable li { height: 1.5em; line-height: 1.2em; }
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
	</style>

<title>ABC AND YOU</title>

<!-- jquery and jqueryui 
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
-->
<!-- mootools -->
<script type="text/javascript" src="mootools-core-1.4.5-full-compat.js"></script>

<?php 
include("check_login.php");
include("db_connect.php");

//db connection
$conn = dbConnect();

//query
$query = "select name, score_needed, count_by, start_number, end_number, tick_length, next_level, number_of_chasers, speed, left_bounds, right_bounds, top_bounds, bottom_bounds, collision_distance from math_games where level = ";
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
$leftBounds;
$rightBounds;
$topBounds;
$bottomBounds;
$collisionDistance;

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
	$leftBounds = $row[9];
	$rightBounds = $row[10];
	$topBounds = $row[11];
	$bottomBounds = $row[12];
	$collisionDistance = $row[13];
	
	$_SESSION["math_game_next_level"] = $nextLevel;
}

?>

<script language="javascript">

//GLOBALS
//application
var mApplication;

//window
var mWindow;

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

var mProposedX = 0;
var mProposedY = 0;

var mControlObject;

//score
var mScore = 0;

//time
var mTimeSinceEpoch = 0;
var mLastTimeSinceEpoch = 0;
var mTimeSinceLastInterval = 0;

//questions
var mQuestion = 0;
var mAnswer = 0;

// id counter
var mIdCount = 0;

//chasers
var mAiCounter = 0;
var mAiCounterDelay = 10;

//dimensions
var mDefaultSpriteSize = 50;

//key pressed
var mKeyLeft = false;
var mKeyRight = false;
var mKeyUp = false;
var mKeyDown = false;
var mKeyStop = false;

var Application = new Class(
{
	initialize: function(scoreNeeded, countBy, startNumber, endNumber, tickLength, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
	{
		//score
        	this.mScoreNeeded = scoreNeeded;

        	//count
        	this.mCountBy = countBy;
        	this.mStartNumber = startNumber;
        	this.mEndNumber = endNumber; 

        	//ticks
        	this.mTickLength = tickLength;

        	//speed
        	this.mSpeed = speed;
	
		//chasers
		this.mNumberOfChasers = numberOfChasers;

		//dimensions
		this.mLeftBounds = leftBounds;
		this.mRightBounds = rightBounds;
		this.mTopBounds = topBounds;
		this.mBottomBounds = bottomBounds;

		//collisionDistnce
		this.mCollisionDistance = collisionDistance;	
	}
});

function init()
{
	mWindow = window.getSize();
 
        //create game   
        //var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength, $numberOfChasers, $speed, $leftBounds, $rightBounds, $topBounds, $bottomBounds, $collisionDistance);"; ?>
	
	mApplication = new Application(<?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength, $numberOfChasers, $speed, $leftBounds, $rightBounds, $topBounds, $bottomBounds, $collisionDistance);"; ?>
	//createWorld
	createWorld();

	//this will be used for resetting to
	resetGame();

	g = new Date();
	mGameStartTime = g.getTime();
	
	update();	
}

function log(msg) {
    setTimeout(function() {
        throw new Error(msg);
    }, 0);
}

function update()
{	
	if (mGameOn)
	{
		//get time since epoch and set lasttime	
		e = new Date();
		mLastTimeSinceEpoch = mTimeSinceEpoch;
		mTimeSinceEpoch = e.getTime();
		
		//set timeSinceLastInterval as function of timeSinceEpoch and LastTimeSinceEpoch diff
		mTimeSinceLastInterval = mTimeSinceEpoch - mLastTimeSinceEpoch;
		
		//old update only
		updateGame();	
		
		render();	
		var t=setTimeout("update()",20)
	}
}

function updateGame()
{
	
	//checkKeys
	checkKeys();

	//run ai		
	if (mAiCounter > mAiCounterDelay)
	{	
		ai();
		mAiCounter = 0;
	}
	mAiCounter++;

	//move players	
	moveShapes();

	//door entered?
	checkForDoorEntered();

	//reality check for out of bounds for avatar
	checkForOutOfBounds();
	
	//check collisions
       	checkForCollisions();
	
	//check for end game
	checkForScoreNeeded();
	
	//save old positions
	saveOldPositions();
}

function ai()
{
	for (i = 0; i < mServerShapeArray.length; i++)
	{
		if (mServerShapeArray[i].mAI == true)
		{
			var direction = Math.floor(Math.random()*9)	
	                if (direction == 0) //left
                        {
                                mServerShapeArray[i].mKeyX = -1;
                                mServerShapeArray[i].mKeyY = 0;
                        }
                        if (direction == 1) //right
                        {
                                mServerShapeArray[i].mKeyX = 1;
                                mServerShapeArray[i].mKeyY = 0;
                        }
                        if (direction == 2) //up
                        {
                                mServerShapeArray[i].mKeyX = 0;
                                mServerShapeArray[i].mKeyY = -1;
                        }
                        if (direction == 3) //down
                        {
                                mServerShapeArray[i].mKeyX = 0;
                                mServerShapeArray[i].mKeyY = 1;
                        }
                        if (direction == 4) //leftup
                        {
                                mServerShapeArray[i].mKeyX = -.5;
                                mServerShapeArray[i].mKeyY = -.5;
                        }
                        if (direction == 5) //leftdown
                        {
                                mServerShapeArray[i].mKeyX = -.5;
                                mServerShapeArray[i].mKeyY = .5;
                        }
                        if (direction == 6) //rightup
                        {
                                mServerShapeArray[i].mKeyX = .5;
                                mServerShapeArray[i].mKeyY = -.5;
                        }
                        if (direction == 7) //rightdown
                        {
                                mServerShapeArray[i].mKeyX = .5;
                                mServerShapeArray[i].mKeyY = .5;
                        }
                        if (direction == 8) //stop
                        {
                                mServerShapeArray[i].mKeyX = 0;
                                mServerShapeArray[i].mKeyY = 0;
                        }
	
		} 
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

function fillSpawnPositionArrays()
{
	for (i=mApplication.mLeftBounds + mDefaultSpriteSize / 2; i <= mApplication.mRightBounds - mDefaultSpriteSize / 2; i = i + mDefaultSpriteSize)
	{ 	
		mPositionXArray.push(i);	
	}
	
	for (i=mApplication.mTopBounds + mDefaultSpriteSize / 2; i <= mApplication.mBottomBounds - mDefaultSpriteSize / 2; i = i + mDefaultSpriteSize)
	{ 	
		mPositionYArray.push(i);	
	}
}

function createServerShapes()
{
	//control object	
	createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,0,0,true,false,"",true,true,false,false,"","blue","");
	
	for (i = mApplication.mStartNumber + mApplication.mCountBy; i <= mApplication.mEndNumber; i = i + mApplication.mCountBy)
	{
		setUniqueSpawnPosition();
		createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,mPositionXArray[mProposedX],mPositionYArray[mProposedY],false,true,i,true,true,false,false,"","yellow","");
	}

	for (i = 0; i < mApplication.mNumberOfChasers; i++)
	{
		setUniqueSpawnPosition();
		createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,mPositionXArray[mProposedX],mPositionYArray[mProposedY],false,true,"",true,true,true,false,"","red","");
	}

	//control buttons	
	createServerShape("",100,100,-200,0,false,false,"",false,false,false,true,"","",moveLeft);
	createServerShape("",100,100,200,0,false,false,"",false,false,false,true,"","",moveRight);
	createServerShape("",100,100,0,-200,false,false,"",false,false,false,true,"","",moveUp);
	createServerShape("",100,100,0,200,false,false,"",false,false,false,true,"","",moveDown);
	createServerShape("",100,100,0,0,false,false,"",false,false,false,true,"","",moveStop);
}

function setUniqueSpawnPosition()
{
	//get random spawn element
	mProposedX = Math.floor(Math.random()*mPositionXArray.length);
	mProposedY = Math.floor(Math.random()*mPositionYArray.length);

	for (r= 0; r < mServerShapeArray.length; r++)
	{
		if (mPositionXArray[mProposedX] == mServerShapeArray[r].mPositionX && mPositionYArray[mProposedY] == mServerShapeArray[r].mPositionY)
		{
			r = 0;
			mProposedX = Math.floor(Math.random()*mPositionXArray.length);
			mProposedY = Math.floor(Math.random()*mPositionYArray.length);
		}
		if (r > 0)
		{	
			if (
			    Math.abs(mPositionXArray[mProposedX] - mServerShapeArray[r-1].mPositionX) > 350 
				  ||
		            Math.abs(mPositionYArray[mProposedY] - mServerShapeArray[r-1].mPositionY) > 350			
			   ) 
			{
				r = 0;
				mProposedX = Math.floor(Math.random()*mPositionXArray.length);
				mProposedY = Math.floor(Math.random()*mPositionYArray.length);
			}
			if (
			    Math.abs(mPositionXArray[mProposedX] - mControlObject.mPositionX) < 100 
				 && 
		            Math.abs(mPositionYArray[mProposedY] - mControlObject.mPositionY) < 100			
			   ) 
			{
				r = 0;
				mProposedX = Math.floor(Math.random()*mPositionXArray.length);
				mProposedY = Math.floor(Math.random()*mPositionYArray.length);
			}
			
		}
	}
}

function createLeftWall()
{
        for (i=-275; i <= 275; i = i + mDefaultSpriteSize)
	{
		createServerShape("",1,mDefaultSpriteSize,mApplication.mLeftBounds,i,false,false,"",true,true,false,false,"","black","");
	}
}

function createRightWall()
{
       	var greenDoorCount = 0; 
	for (i=-275; i <= 275; i = i + mDefaultSpriteSize)
	{
		if (greenDoorCount == 0 || greenDoorCount == 1)
		{
			createServerShape("",1,mDefaultSpriteSize,mApplication.mRightBounds,i,false,false,"",true,true,false,false,"","green","");
		}	
		else
		{	
			createServerShape("",1,mDefaultSpriteSize,mApplication.mRightBounds,i,false,false,"",true,true,false,false,"","black","");
		}
		greenDoorCount++;
	}
	
}

function createTopWall()
{
        for (i=-375; i <= 375; i = i + mDefaultSpriteSize)
	{
		createServerShape("",mDefaultSpriteSize,1,i,mApplication.mTopBounds,false,false,"",true,true,false,false,"","black","");
	}
}

function createBottomWall()
{
        for (i=-375; i <= 375; i = i + mDefaultSpriteSize)
	{
		createServerShape("",mDefaultSpriteSize,1,i,mApplication.mBottomBounds,false,false,"",true,true,false,false,"","black","");
	}
}

function createServerShape(src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
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
	shape.mKeyX = 0;
	shape.mKeyY = 0;
	shape.mCollidable = collidable;
	shape.mCollisionOn = collisionOn;
	shape.mIsQuestion = isQuestion;
	shape.mAnswer = answer;
	shape.mAI = ai;	
	shape.mGui = gui;
	shape.mInnerHTML = innerHTML; 
	shape.mBackgroundColor = backgroundColor;
	shape.mOnClick = onClick;
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
	
	div.style.backgroundColor = mServerShapeArray[i].mBackgroundColor;
	
	//add div to array
	mClientDivArray.push(div);

	//create clientImage
	if (mServerShapeArray[i].mSrc)
	{
		createClientImage(i);
	}
	else if (mServerShapeArray[i].mSrc == "")//create paragraph
	{
		if (mServerShapeArray[i].mGui)
		{		
			createClientButton(i);
		}
		else
		{
			createClientParagraph(i);
		}
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
	button.id = 'button' + i;
	button.style.width=mServerShapeArray[i].mWidth+'px';
	button.style.width=mServerShapeArray[i].mHeight+'px';
	button.innerHTML = mServerShapeArray[i].mInnerHTML;
	button.onclick = mServerShapeArray[i].mOnClick;
	button.style.backgroundColor = 'transparent';
	button.style.border = 'thin none #FFFFFF';
        button.style.width=mServerShapeArray[i].mWidth+'px'; 
        button.style.height=mServerShapeArray[i].mHeight+'px'; 
	mClientShapeArray.push(button);
}


function saveOldPositions()
{
        //move numbers
        for (i = 0; i < mServerShapeArray.length; i++)
        {
                //record old position to use for collisions or whatever you fancy
                mServerShapeArray[i].mOldPositionX = mServerShapeArray[i].mPositionX;
                mServerShapeArray[i].mOldPositionY = mServerShapeArray[i].mPositionY;
        }
}

function moveShapes()
{
        //move numbers
        for (i = 0; i < mServerShapeArray.length; i++)
        {
		//update Velocity
		mServerShapeArray[i].mVelocityX = mServerShapeArray[i].mKeyX * mTimeSinceLastInterval * mApplication.mSpeed;
		mServerShapeArray[i].mVelocityY = mServerShapeArray[i].mKeyY * mTimeSinceLastInterval * mApplication.mSpeed;

		//update position
		mServerShapeArray[i].mPositionX += mServerShapeArray[i].mVelocityX;
		mServerShapeArray[i].mPositionY += mServerShapeArray[i].mVelocityY;
        }
}



function checkForCollisions()
{
	for (s = 0; s < mServerShapeArray.length; s++)
	{
	       	var x1 = mServerShapeArray[s].mPositionX;
	       	var y1 = mServerShapeArray[s].mPositionY;
 
		for (i = 0; i<mServerShapeArray.length; i++)
       		{
			if (mServerShapeArray[i] == mServerShapeArray[s])
			{
				//skip
			}
			else
			{
				if (mServerShapeArray[i].mCollisionOn == true && mServerShapeArray[s].mCollisionOn == true)
                		{
                        		var x2 = mServerShapeArray[i].mPositionX;              
                     			var y2 = mServerShapeArray[i].mPositionY;              
                
                        		var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                        		if (distSQ < mApplication.mCollisionDistance) 
                        		{
						evaluateCollision(mServerShapeArray[s].mId,mServerShapeArray[i].mId);		      
                        		}
				}
                	}       
        	}
	}
}
function checkForOutOfBounds()
{
	for (i = 0; i < mServerShapeArray.length; i++)
	{	
		if (mServerShapeArray[i].mPositionX < mApplication.mLeftBounds)
		{
			mServerShapeArray[i].mPositionX = mApplication.mLeftBounds;		
		}
		if (mServerShapeArray[i].mPositionX > mApplication.mRightBounds)
		{
			mServerShapeArray[i].mPositionX = mApplication.mRightBounds;
		}
		if (mServerShapeArray[i].mPositionY < mApplication.mTopBounds)
		{
			mServerShapeArray[i].mPositionY = mApplication.mTopBounds;
		}
		if (mServerShapeArray[i].mPositionY > mApplication.mBottomBounds)
		{
			mServerShapeArray[i].mPositionY = mApplication.mBottomBounds;
		}
	}
}

window.onresize = function(event)
{
	mWindow = window.getSize();
}

//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
        //loop thru player array and update their xy positions
        for (i=0; i<mServerShapeArray.length; i++)
        {
		//get the center of the page xy
       		var pageCenterX = mWindow.x / 2;
        	var pageCenterY = mWindow.y / 2;
      
       		//get the center xy of the image
       		var shapeCenterX = mServerShapeArray[i].mWidth / 2;     
       		var shapeCenterY = mServerShapeArray[i].mHeight / 2;     

		//if control object center it on screen
		if (mServerShapeArray[i] == mControlObject || mServerShapeArray[i].mGui == true)
		{
			//shift the position based on pageCenterXY and shapeCenterXY	
        		var posX = pageCenterX - shapeCenterX;     
        		var posY = pageCenterY - shapeCenterY;     
			
			if (mServerShapeArray[i] == mControlObject)
			{
				//this actual moves it  
        			mClientDivArray[i].style.left = posX+'px';
        			mClientDivArray[i].style.top  = posY+'px';
			}
			else if (mServerShapeArray[i].mGui == true)
			{
				
				//we also need to resize gui based on size...
        			//button.style.width=mServerShapeArray[i].mWidth+'px'; 
        			//button.style.height=mServerShapeArray[i].mHeight+'px'; 
				
				//get the new size....
        			mServerShapeArray[i].mWidth = mWindow.x / 3;
        			mServerShapeArray[i].mHeight = mWindow.y / 3;

				if (mServerShapeArray[i].mInnerHTML == "DOWN")
				{
					mServerShapeArray[i].mHeight = mServerShapeArray[i].mHeight - 13;
				}
				
				mClientShapeArray[i].style.width=mServerShapeArray[i].mWidth+'px'; 
        			mClientShapeArray[i].style.height=mServerShapeArray[i].mHeight+'px'; 
					

				//now get the position
				if (mServerShapeArray[i].mOnClick == moveLeft)
				{
					mServerShapeArray[i].mPositionX = 0; 
					mServerShapeArray[i].mPositionY = mWindow.y / 2 - shapeCenterY; 
				}
				if (mServerShapeArray[i].mOnClick == moveRight)
				{
					var tempx = mWindow.x / 6;
					tempx = mWindow.x - tempx;
					
					mServerShapeArray[i].mPositionX = tempx - shapeCenterX; 
					mServerShapeArray[i].mPositionY = mWindow.y / 2 - shapeCenterY; 
				}
				if (mServerShapeArray[i].mOnClick == moveUp)
				{
					mServerShapeArray[i].mPositionX = mWindow.x / 2 - shapeCenterX; 
					mServerShapeArray[i].mPositionY = 0; 
				}
				if (mServerShapeArray[i].mOnClick == moveDown)
				{
					mServerShapeArray[i].mPositionX = mWindow.x / 2 - shapeCenterX; 
					
					var tempy = mWindow.y / 6;
					tempy = mWindow.y - tempy;
					mServerShapeArray[i].mPositionY = tempy - shapeCenterY - 13; 
					
				}
				if (mServerShapeArray[i].mOnClick == moveStop)
				{
					mServerShapeArray[i].mPositionX = mWindow.x / 2 - shapeCenterX; 
					mServerShapeArray[i].mPositionY = mWindow.y / 2 - shapeCenterY; 
				}
 
        			mClientDivArray[i].style.left = mServerShapeArray[i].mPositionX+'px';
        			mClientDivArray[i].style.top  = mServerShapeArray[i].mPositionY+'px';
				
			}
		} 
		
		//else if anything else render relative to the control object	
		else
		{
			//get the offset from control object
			var xdiff = mServerShapeArray[i].mPositionX - mControlObject.mPositionX;  
                	var ydiff = mServerShapeArray[i].mPositionY - mControlObject.mPositionY;  

                	//center image relative to position
                	var posX = xdiff + pageCenterX - shapeCenterX;
                	var posY = ydiff + pageCenterY - shapeCenterY;    
			
			//if off screen then hide it so we don't have scroll bars mucking up controls 
                        if (posX + mServerShapeArray[i].mWidth  + 3 > mWindow.x ||
			    posY + mServerShapeArray[i].mHeight + 13 > mWindow.y)
			{
                		mClientDivArray[i].style.left = 0+'px';
                       		mClientDivArray[i].style.top  = 0+'px';
				mClientDivArray[i].style.visibility = 'hidden';	
			}
			else //within dimensions..and still collidable(meaning a number that has been answered) or not a question at all
			{
				if (mServerShapeArray[i].mCollisionOn || 
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
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + mApplication.mScoreNeeded;
}

function checkForScoreNeeded()
{
        if (mScore == mApplication.mScoreNeeded)
        {
		//open the doors
		for (i=0; i < mServerShapeArray.length; i++)
		{
			if (mServerShapeArray[i].mBackgroundColor == 'green')
			{
				mServerShapeArray[i].mBackgroundColor = 'white';
				mClientDivArray[i].style.backgroundColor = 'white';
			}
		}
	}
}

function checkForDoorEntered()
{
        //if (mDoorEntered)
        if (mScore == mApplication.mScoreNeeded)
        {
		if (mControlObject.mPositionX > mApplication.mRightBounds - mDefaultSpriteSize / 2 &&
		    mControlObject.mPositionY > mApplication.mTopBounds &&
		    mControlObject.mPositionY < mApplication.mTopBounds + mDefaultSpriteSize * 2) 
		    	
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
         
		//set every shape to spawn position	
		mServerShapeArray[i].mPositionX = mServerShapeArray[i].mSpawnPositionX;
		mServerShapeArray[i].mPositionY = mServerShapeArray[i].mSpawnPositionY;

	      	if (mServerShapeArray[i].mCollidable == true)
		{ 
			mServerShapeArray[i].mCollisionOn = true;
                	mClientDivArray[i].style.visibility = 'visible';
		}
        }
	mControlObject.mPositionX = 0;     
	mControlObject.mPositionY = 0;     
 
        //score
        mScore = 0;

        //game
        mQuestion = mApplication.mCount;

        //count
        mApplication.mCount = mApplication.mStartNumber;
        
	var mAnswer = 0;
	//answer
	newAnswer();
        mClientShapeArray[0].innerHTML=mApplication.mCount;
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
                		mApplication.mCount = mApplication.mCount + mApplication.mCountBy;  //add to count
                		mScore++;
				mServerShapeArray[mId2].mCollisionOn = false;
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
        mQuestion = mApplication.mCount;
        document.getElementById("question").innerHTML="Question: " + mQuestion;
        mClientShapeArray[0].innerHTML=mApplication.mCount;
}

//new answer
function newAnswer()
{
        mAnswer = mApplication.mCount + mApplication.mCountBy;
}

//CONTROLS
function moveLeft()
{
	mControlObject.mKeyX = -1;
        mControlObject.mKeyY = 0;
}

function moveRight()
{
        mControlObject.mKeyX = 1;
        mControlObject.mKeyY = 0;
}

function moveUp()
{
        mControlObject.mKeyX = 0;
        mControlObject.mKeyY = -1;
}

function moveDown()
{
        mControlObject.mKeyX = 0;
        mControlObject.mKeyY = 1;
}

function moveStop()
{
        mControlObject.mKeyX = 0;
        mControlObject.mKeyY = 0;
}

window.addEvent('domready', function()
{
	document.addEvent("keydown", this.onkeydown);
	document.addEvent("keyup", this.onkeyup);
}) ;

function onkeydown(event)
{
        if (event.key == 'left')
        {
                mKeyLeft = true;
        }
        if (event.key == 'right')
        {
                mKeyRight = true;
        }
        if (event.key == 'up')
        {
                mKeyUp = true;
        }
        if (event.key == 'down')
        {
                mKeyDown = true;
        }
        if (event.key == 'space')
        {
                mKeyStop = true;
        }
}

function onkeyup(event)
{
        if (event.key == 'left')
        {
                mKeyLeft = false;
        }
        if (event.key == 'right')
        {
                mKeyRight = false;
        }
        if (event.key == 'up')
        {
                mKeyUp = false;
        }
        if (event.key == 'down')
        {
                mKeyDown = false;
        }
        if (event.key == 'space')
        {
                mKeyStop = false;
        }
}

function checkKeys()
{
        //left  
        if (mKeyLeft == true && mKeyRight == false && mKeyUp == false && mKeyDown == false && mKeyStop == false)
        {
                mControlObject.mKeyX = -1;
                mControlObject.mKeyY = 0;
        }
        
        //right 
        if (mKeyLeft == false && mKeyRight == true && mKeyUp == false && mKeyDown == false && mKeyStop == false)
        {
                mControlObject.mKeyX = 1;
                mControlObject.mKeyY = 0;
        }
        
        //up    
        if (mKeyLeft == false && mKeyRight == false && mKeyUp == true && mKeyDown == false && mKeyStop == false)
        {
                mControlObject.mKeyX = 0;
                mControlObject.mKeyY = -1;
        }
        //down  
        if (mKeyLeft == false && mKeyRight == false && mKeyUp == false && mKeyDown == true && mKeyStop == false)
        {
                mControlObject.mKeyX = 0;
                mControlObject.mKeyY = 1;
        }
        //left_up       
        if (mKeyLeft == true && mKeyRight == false && mKeyUp == true && mKeyDown == false && mKeyStop == false)
        {
                mControlObject.mKeyX = -.5;
                mControlObject.mKeyY = -.5;
        }
        //left_down     
        if (mKeyLeft == true && mKeyRight == false && mKeyUp == false && mKeyDown == true && mKeyStop == false)
        {
                mControlObject.mKeyX = -.5;
                mControlObject.mKeyY = .5;
        }
        //right_up      
        if (mKeyLeft == false && mKeyRight == true && mKeyUp == true && mKeyDown == false && mKeyStop == false)
        {
                mControlObject.mKeyX = .5;
                mControlObject.mKeyY = -.5;
        }
        //right_down    
        if (mKeyLeft == false && mKeyRight == true && mKeyUp == false && mKeyDown == true && mKeyStop == false)
        {
                mControlObject.mKeyX = .5;
                mControlObject.mKeyY = .5;
        }
        //all up...stop 
        if (mKeyLeft == false && mKeyRight == false && mKeyUp == false && mKeyDown == false)
        {
                mControlObject.mKeyX = 0;
                mControlObject.mKeyY = 0;
        }
        //stop  
        if (mKeyStop == true)
        {
                mControlObject.mKeyX = 0;
                mControlObject.mKeyY = 0;
        }
}



</script>

</head>
<body>
<script type="text/javascript"> 
window.addEvent('domready', function()
{
//$(document).ready(function()
//{
        init();
}
);

</script>

<div class="demo">

<ul id="sortable">
	<li id="game_name" class="ui-state-default"> <?php echo "$name"; ?> </li>
	<li id="question" class="ui-state-default"> <?php echo $startNumber - 1; ?> </li>
	<li id="feedback" class="ui-state-default"> Have Fun! </li>
	<li id="score" class="ui-state-default"> Score: 0</li>
	<li id="scoreNeeded" class="ui-state-default"> Score Needed: <?php echo "$scoreNeeded"; ?> </li>
</ul>

</div><!-- End demo -->


</body>
</html>
