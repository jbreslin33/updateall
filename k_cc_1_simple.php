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
var mFrameCount = 0;
var mRenderCount = 0;


var mGameTime = 0;
var mGameStartTime = 0;
var mTimeSinceEpoch = 0;
var mLastTimeSinceEpoch = 0;
var mTimeSinceLastInterval = 0;
var mFrameTime = 0;

var mInterpolation = 0;

//questions
var mQuestion = 0;
var mAnswer = 0;

// id counter
var mIdCount = 0;

//chasers
var mNumberOfChasers = 0;

var mAiCounter = 0;
var mAiCounterDelay = 10;

//dimensions
var mDefaultSpriteSize = 50;
var mLeftBounds = -400;
var mRightBounds = 400;
var mTopBounds = -300;
var mBottomBounds = 300;

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
//	setInterv/al(update,mSkipTicks);
	
	g = new Date();
	mGameStartTime = g.getTime();
		
	//var interval = self.setInterval("update()",15);
	update();	
	
}

var mLasTimeSinceEpoch = 0;


function update()
{	
	if (mGameOn)
	{
		//if (mFrameTime > mTickLength) //this is always true, why?
		//{
		
		//just print game start time it's only used in calcs not updated
        	document.getElementById("gameStartTime").innerHTML="gameStartTime: " + mGameStartTime;
		
		//get time since epoch and set lasttime	
		e = new Date();
		mLastTimeSinceEpoch = mTimeSinceEpoch;
		mTimeSinceEpoch = e.getTime();
        	document.getElementById("epoch").innerHTML="epoch: " + mTimeSinceEpoch;
		
		//set timeSinceLastInterval as function of timeSinceEpoch and LastTimeSinceEpoch diff
		mTimeSinceLastInterval = mTimeSinceEpoch - mLastTimeSinceEpoch;
        	document.getElementById("timeSinceLastInterval").innerHTML="timeSinceLastInterval " + mTimeSinceLastInterval;
		
		//accumulate mFrameTime	
		mFrameTime += mTimeSinceLastInterval;
        	document.getElementById("frameTime").innerHTML="frameTime: " + mFrameTime;
		
		//calc gameTime elapsed based on epoch and starttime	
		mGameTime = mTimeSinceEpoch - mGameStartTime;	
        	document.getElementById("gameTime").innerHTML="gameTime: " + mGameTime;

			
        	document.getElementById("tickLength").innerHTML="tickLength: " + mTickLength;

		//interpolation calc
		mInterpolation = mFrameTime / mTickLength; 	
        	document.getElementById("interpolation").innerHTML="interpolation: " + mInterpolation;
	
		//old update only
		updateGame();	
		mFrameCount++;
       		document.getElementById("frameCount").innerHTML="frameCount: " + mFrameCount;
			
		mFrameTime = 0;
		//end old update only

		mRenderCount++;	
		render();	
        	document.getElementById("renderCount").innerHTML="renderCount: " + mRenderCount;
		var t=setTimeout("update()",20)
	}	
	//}
}

function updateGame()
{
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

	//check collisions
       	checkForCollisions();
	
	//check for end game
	checkForScoreNeeded();
		
}

function ai()
{
	for (i = 0; i < mServerShapeArray.length; i++)
	{
		if (mServerShapeArray[i].mAI == true)
		{
			var direction = Math.floor(Math.random()*4)	
			if (direction == 0)
			{
				mServerShapeArray[i].mVelocityX = -1 * mSpeed * mInterpolation;
				mServerShapeArray[i].mVelocityY = 0;
			}
			if (direction == 1)
			{
				mServerShapeArray[i].mVelocityX = 1 * mSpeed * mInterpolation;
				mServerShapeArray[i].mVelocityY = 0;
			}
			if (direction == 2)
			{	
				mServerShapeArray[i].mVelocityX = 0;
				mServerShapeArray[i].mVelocityY = -1 * mSpeed * mInterpolation;
			}
			if (direction == 3)
			{
				mServerShapeArray[i].mVelocityX = 0;
				mServerShapeArray[i].mVelocityY = 1 * mSpeed * mInterpolation;
			}
			if (direction == 4)
			{
				mServerShapeArray[i].mVelocityX = 0;
				mServerShapeArray[i].mVelocityY = 0;
			}
		} 
	}
}

function createWorld()
{
	fillSpawnPositionArrays();
	createServerShapes();
	
	createLeftWall();
//	createRightWall();
//	createTopWall();
//	createBottomWall();
}

function createServerShapes()
{
	//control object	
	createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,0,0,true,false,"",true,true,false,false,"","green","");
	
	for (i = 0; i <= 9; i++)
	{
		setUniqueSpawnPosition();
		createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,mPositionXArray[proposedX],mPositionYArray[proposedY],false,true,mStartNumber + i,true,true,false,false,"","yellow","");
	}

	for (i = 0; i < mNumberOfChasers; i++)
	{
		setUniqueSpawnPosition();
		createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,mPositionXArray[proposedX],mPositionYArray[proposedY],false,true,"",true,true,true,false,"","red","");
	}

	//control buttons	
//	createServerShape("",100,100,-200,0,false,false,"",false,false,false,true,"","",moveLeft);
//	createServerShape("",100,100,200,0,false,false,"",false,false,false,true,"","",moveRight);
//	createServerShape("",100,100,0,-200,false,false,"",false,false,false,true,"","",moveUp);
//	createServerShape("",100,100,0,200,false,false,"",false,false,false,true,"","",moveDown);
//	createServerShape("",100,100,0,0,false,false,"",false,false,false,true,"","",moveStop);
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
	for (i=mLeftBounds + mDefaultSpriteSize / 2; i <= mRightBounds - mDefaultSpriteSize / 2; i = i + mDefaultSpriteSize)
	{ 	
		mPositionXArray.push(i);	
	}
	
	for (i=mTopBounds + mDefaultSpriteSize / 2; i <= mBottomBounds - mDefaultSpriteSize / 2; i = i + mDefaultSpriteSize)
	{ 	
		mPositionYArray.push(i);	
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
	div.appendChild(mClientShapeArray[i].cloneNode(true));
//oParent.appendChild(balls[0].cloneNode(true));
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

function createLeftWall()
{
        for (i=-275; i <= 275; i = i + mDefaultSpriteSize)
	{
		//createServerShape('red_wall.png',1,mDefaultSpriteSize,mLeftBounds,i,false,false,"",true,true,false,false,"","yellow","");
		createServerShape("",mDefaultSpriteSize,mDefaultSpriteSize,mLeftBounds,i,false,false,"",true,true,false,false,"","black","");
	}
}

function createRightWall()
{
       	var greenDoorCount = 0; 
	for (i=-275; i <= 275; i = i + mDefaultSpriteSize)
	{
		if (greenDoorCount == 0 || greenDoorCount == 1)
		{
			createServerShape('green_wall.png',1,mDefaultSpriteSize,mRightBounds,i,false,false,"",true,true,false,false,"","yellow","");
		}	
		else
		{	
			createServerShape('red_wall.png',1,mDefaultSpriteSize,mRightBounds,i,false,false,"",true,true,false,false,"","yellow","");
		}
		greenDoorCount++;
	}
	
}

function createTopWall()
{
        for (i=-375; i <= 375; i = i + mDefaultSpriteSize)
	{
		createServerShape('red_wall.png',mDefaultSpriteSize,1,i,mTopBounds,false,false,"",true,true,false,false,"","yellow","");
	}
}

function createBottomWall()
{
        for (i=-375; i <= 375; i = i + mDefaultSpriteSize)
	{
		createServerShape('red_wall.png',mDefaultSpriteSize,1,i,mBottomBounds,false,false,"",true,true,false,false,"","yellow","");
	}
}

function moveShapes()
{
        //move numbers
        for (i = 0; i < mServerShapeArray.length; i++)
        {
		//record old position to use for collisions or whatever you fancy	
		mServerShapeArray[i].mOldPositionX = mServerShapeArray[i].mPositionX;
		mServerShapeArray[i].mOldPositionY = mServerShapeArray[i].mPositionY;
	
		//move shape	
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
        			mServerShapeArray[i].mWidth = $(this).width() / 3;
        			mServerShapeArray[i].mHeight = $(this).height() / 3;

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
					mServerShapeArray[i].mPositionY = $(this).height() / 2 - shapeCenterY; 
				}
				if (mServerShapeArray[i].mOnClick == moveRight)
				{
					var tempx = $(this).width() / 6;
					tempx = $(this).width() - tempx;
					
					mServerShapeArray[i].mPositionX = tempx - shapeCenterX; 
					mServerShapeArray[i].mPositionY = $(this).height() / 2 - shapeCenterY; 
				}
				if (mServerShapeArray[i].mOnClick == moveUp)
				{
					mServerShapeArray[i].mPositionX = $(this).width() / 2 - shapeCenterX; 
					mServerShapeArray[i].mPositionY = 0; 
				}
				if (mServerShapeArray[i].mOnClick == moveDown)
				{
					mServerShapeArray[i].mPositionX = $(this).width() / 2 - shapeCenterX; 
					
					var tempy = $(this).height() / 6;
					tempy = $(this).height() - tempy;
					mServerShapeArray[i].mPositionY = tempy - shapeCenterY - 13; 
					
				}
				if (mServerShapeArray[i].mOnClick == moveStop)
				{
					mServerShapeArray[i].mPositionX = $(this).width() / 2 - shapeCenterX; 
					mServerShapeArray[i].mPositionY = $(this).height() / 2 - shapeCenterY; 
				}

				

				//this actual moves it 
		//		posX = posX + mServerShapeArray[i].mPositionX; 
		//		posY = posY + mServerShapeArray[i].mPositionY;
 
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
                        if (posX + mServerShapeArray[i].mWidth  + 3 > $(this).width() ||
			    posY + mServerShapeArray[i].mHeight + 13 > $(this).height())
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
		if (mControlObject.mPositionX > mRightBounds - mDefaultSpriteSize / 2 &&
		    mControlObject.mPositionY > mTopBounds &&
		    mControlObject.mPositionY < mTopBounds + mDefaultSpriteSize * 2) 
		    	
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
        mControlObject.mVelocityX = -1 * mSpeed * mInterpolation;
        mControlObject.mVelocityY = 0;
}

function moveRight()
{
        mControlObject.mVelocityX = 1 * mSpeed * mInterpolation;
        mControlObject.mVelocityY = 0;
}

function moveUp()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = -1 * mSpeed * mInterpolation;
}

function moveDown()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = 1 * mSpeed * mInterpolation;
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

<!-- create frameCount -->
<p id="frameCount">frameCount: </p>

<!-- create renderCount-->
<p id="renderCount">renderCount: </p>

<!-- create gameStartTime-->
<p id="gameStartTime">gameStartTime: </p>

<!-- create epoch-->
<p id="epoch">epoch: </p>

<!-- create gameTime-->
<p id="gameTime">gameTime: </p>

<!-- create frameTime-->
<p id="frameTime">frameTime: </p>

<!-- create tickLength-->
<p id="tickLength">tickLength: </p>

<!-- create timeSinceLastInterval-->
<p id="timeSinceLastInterval">timeSinceLastInterval: </p>

<!-- create interpolation-->
<p id="interpolation">interpolation: </p>

</body>
</html>
