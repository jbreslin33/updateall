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

//game
var mGame;

//shapes
var mPositionXArray = new Array();
var mPositionYArray = new Array();

var mSlotPositionXArray = new Array();
var mSlotPositionYArray = new Array();

var Shape = new Class(
{
	initialize: function (game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
	{
		this.mGame = game;	
		this.mSrc = src;
		this.mId = id;
		
		this.mSpawnPositionX = spawnX;
		this.mSpawnPositionY = spawnY;
		this.mWidth = width;
		this.mHeight = height;
		this.mPositionX = spawnX;
		this.mPositionY = spawnY;
		this.mOldPositionX = spawnX;
		this.mOldPositionY = spawnY;
		this.mVelocityX = 0;
		this.mVelocityY = 0;
		this.mKeyX = 0;
		this.mKeyY = 0;
		this.mCollidable = collidable;
		this.mCollisionOn = collisionOn;
		this.mIsQuestion = isQuestion;
		this.mAnswer = answer;
		this.mAI = ai;	
		this.mGui = gui;
		this.mInnerHTML = innerHTML; 
		this.mBackgroundColor = backgroundColor;
		this.mOnClick = onClick;
 		
		if (isControlObject)
		{
			this.mGame.mControlObject = this;
		}
	
		//add to array
		this.mGame.mShapeArray.push(this);
	
		//create the movable div that will be used to move image around.	
		this.mDiv = document.createElement('div');
        	this.mDiv.setAttribute('id','div' + this.mGame.mIdCount);
        	this.mDiv.setAttribute("class","demo");
		this.mDiv.style.position="absolute";
		this.mDiv.style.visibility = 'visible';
	
		this.mDiv.style.width= this.mGame.mShapeArray[this.mGame.mIdCount].mWidth;
		this.mDiv.style.height= this.mGame.mShapeArray[this.mGame.mIdCount].mHeight;
	
		//move it
        	this.mDiv.style.left = this.mGame.mShapeArray[this.mGame.mIdCount].mPositionX+'px';
        	this.mDiv.style.top  = this.mGame.mShapeArray[this.mGame.mIdCount].mPositionY+'px';

        	document.body.appendChild(this.mDiv);
	
		this.mDiv.style.backgroundColor = this.mGame.mShapeArray[this.mGame.mIdCount].mBackgroundColor;

		this.mMesh;
	
		//create clientImage
		if (this.mGame.mShapeArray[this.mGame.mIdCount].mSrc)
		{
        		//image to attache to our div "vessel"
        		this.mMesh  = document.createElement("IMG");
        		this.mMesh.id = 'image' + this.mGame.mIdCount;
        		this.mMesh.alt = 'image' + this.mGame.mIdCount;
        		this.mMesh.title = 'image' + this.mGame.mIdCount;   
        		this.mMesh.src  = this.mGame.mShapeArray[this.mGame.mIdCount].mSrc;
        		this.mMesh.style.width=this.mGame.mShapeArray[this.mGame.mIdCount].mWidth+'px'; 
        		this.mMesh.style.height=this.mGame.mShapeArray[this.mGame.mIdCount].mHeight+'px'; 
		}
		else if (this.mGame.mShapeArray[this.mGame.mIdCount].mSrc == "")//create paragraph
		{
			if (this.mGame.mShapeArray[this.mGame.mIdCount].mGui)
			{		
				this.mMesh = document.createElement("button");
				this.mMesh.id = 'button' + this.mGame.mIdCount;
				this.mMesh.style.width=this.mGame.mShapeArray[this.mGame.mIdCount].mWidth+'px';
				this.mMesh.style.width=this.mGame.mShapeArray[this.mGame.mIdCount].mHeight+'px';
				this.mMesh.innerHTML = this.mGame.mShapeArray[this.mGame.mIdCount].mInnerHTML;
				this.mMesh.onclick = this.mGame.mShapeArray[this.mGame.mIdCount].mOnClick;
				this.mMesh.style.backgroundColor = 'transparent';
				this.mMesh.style.border = 'thin none #FFFFFF';
        			this.mMesh.style.width=this.mGame.mShapeArray[this.mGame.mIdCount].mWidth+'px'; 
        			this.mMesh.style.height=this.mGame.mShapeArray[this.mGame.mIdCount].mHeight+'px'; 
			}
			else
			{
				this.mMesh = document.createElement("p");
				this.mMesh.innerHTML = this.mGame.mShapeArray[this.mGame.mIdCount].mAnswer;
			}
		}

		//back to div	
		this.mDiv.appendChild(this.mMesh);
	
	},
	
	update: function()
	{

	}
});

//Application Class
var Application = new Class(
{
	initialize: function(scoreNeeded, countBy, startNumber, endNumber, tickLength, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
	{
		//window size
		this.mWindow = window.getSize();

        	//ticks
        	this.mTickLength = tickLength;
		
		//time
		this.mTimeSinceEpoch = 0;
		this.mLastTimeSinceEpoch = 0;
		this.mTimeSinceLastInterval = 0;
		
		//key pressed
		this.mKeyLeft = false;
		this.mKeyRight = false;
		this.mKeyUp = false;
		this.mKeyDown = false;
		this.mKeyStop = false;

		mGame = new Game(this,<?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $numberOfChasers, $speed, $leftBounds, $rightBounds, $topBounds, $bottomBounds, $collisionDistance);"; ?>
		
		//this will be used for resetting to
		resetGame();

		g = new Date();
		mGameStartTime = g.getTime();
	
		//this.update();	
	},

	update: function()
	{
		if (mGame.mGameOn)
		{
			//get time since epoch and set lasttime	
			e = new Date();
			this.mLastTimeSinceEpoch = this.mTimeSinceEpoch;
			this.mTimeSinceEpoch = e.getTime();
		
			//set timeSinceLastInterval as function of timeSinceEpoch and LastTimeSinceEpoch diff
			this.mTimeSinceLastInterval = this.mTimeSinceEpoch - this.mLastTimeSinceEpoch;
		
			//checkKeys
			this.checkKeys();
			
			//old update only
			mGame.update();	
		
			render();	
			//this.foo();
			var t=setTimeout("mApplication.update()",20)
		}
	},

	foo: function()
	{
		var t=setTimeout("this.update()",20)
	},

	log: function(msg)
	{
		setTimeout(function()
		{
			throw new Error(msg);
		}, 0);
	},

	checkKeys: function()
	{
        	//left  
        	if (this.mKeyLeft == true && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == false)
        	{
                	mGame.mControlObject.mKeyX = -1;
                	mGame.mControlObject.mKeyY = 0;
        	}
        
        	//right 
        	if (this.mKeyLeft == false && this.mKeyRight == true && this.mKeyUp == false && this.mKeyDown == false)
        	{
                	mGame.mControlObject.mKeyX = 1;
                	mGame.mControlObject.mKeyY = 0;
        	}
        
        	//up    
        	if (this.mKeyLeft == false && this.mKeyRight == false && this.mKeyUp == true && this.mKeyDown == false)
        	{
                	mGame.mControlObject.mKeyX = 0;
                	mGame.mControlObject.mKeyY = -1;
        	}
        	//down  
        	if (this.mKeyLeft == false && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == true)
        	{
                	mGame.mControlObject.mKeyX = 0;
                	mGame.mControlObject.mKeyY = 1;
        	}
        	//left_up       
        	if (this.mKeyLeft == true && this.mKeyRight == false && this.mKeyUp == true && this.mKeyDown == false)
        	{
                	mGame.mControlObject.mKeyX = -.5;
                	mGame.mControlObject.mKeyY = -.5;
        	}
        	//left_down     
        	if (this.mKeyLeft == true && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == true)
        	{
                	mGame.mControlObject.mKeyX = -.5;
                	mGame.mControlObject.mKeyY = .5;
        	}
        	//right_up      
        	if (this.mKeyLeft == false && this.mKeyRight == true && this.mKeyUp == true && this.mKeyDown == false)
        	{
                	mGame.mControlObject.mKeyX = .5;
                	mGame.mControlObject.mKeyY = -.5;
        	}
        	//right_down    
        	if (this.mKeyLeft == false && this.mKeyRight == true && this.mKeyUp == false && this.mKeyDown == true)
        	{
                	mGame.mControlObject.mKeyX = .5;
                	mGame.mControlObject.mKeyY = .5;
        	}
        	//all up...stop 
        	if (this.mKeyLeft == false && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == false)
        	{
                	mGame.mControlObject.mKeyX = 0;
                	mGame.mControlObject.mKeyY = 0;
        	}
	}
});

//Game Class
var Game = new Class(
{
	initialize: function(application,scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
	{
		//application
		this.mApplication = application;	
		//On_Off
		this.mGameOn = true;
	
		//shape Array
		this.mShapeArray = new Array();
	
		//control object
		this.mControlObject;
		
		//window size
		this.mWindow = window.getSize();

		//score
      		this.mScore = 0; 
	 	this.mScoreNeeded = scoreNeeded;

        	//count
        	this.mCountBy = countBy;
        	this.mStartNumber = startNumber;
        	this.mEndNumber = endNumber; 

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
		
		//proposed positions	
		this.mProposedX = 0;
		this.mProposedY = 0;
		
		// id counter
		this.mIdCount = 0;

		//chasers
		this.mAiCounter = 0;
		this.mAiCounterDelay = 10;

		//dimensions
		this.mDefaultSpriteSize = 50;

		//fill possible spawnPosition Arrays
		this.fillSpawnPositionArrays();
	
		//create Shapes	
		this.createShapes();

		//create walls		
		this.createLeftWall();
		this.createRightWall();
		this.createTopWall();
		this.createBottomWall();
	},

	update: function()
	{

		//run ai		
		if (mGame.mAiCounter > mGame.mAiCounterDelay)
		{	
			ai();
			mGame.mAiCounter = 0;
		}
		mGame.mAiCounter++;

		//move players	
		this.moveShapes();

		//door entered?
		checkForDoorEntered();

		//reality check for out of bounds for avatar
		this.checkForOutOfBounds();
	
		//check collisions
       		checkForCollisions();
	
		//check for end game
		checkForScoreNeeded();
	
		//save old positions
		saveOldPositions();
	},

	checkForOutOfBounds: function()
	{
		for (i = 0; i < this.mShapeArray.length; i++)
		{	
			if (this.mShapeArray[i].mPositionX < this.mLeftBounds)
			{
				this.mShapeArray[i].mPositionX = this.mLeftBounds;		
			}
			if (this.mShapeArray[i].mPositionX > this.mRightBounds)
			{
				this.mShapeArray[i].mPositionX = this.mRightBounds;
			}
			if (this.mShapeArray[i].mPositionY < this.mTopBounds)
			{
				this.mShapeArray[i].mPositionY = this.mTopBounds;
			}
			if (this.mShapeArray[i].mPositionY > this.mBottomBounds)
			{
				this.mShapeArray[i].mPositionY = this.mBottomBounds;
			}
		}
	},

	fillSpawnPositionArrays: function()
	{
		for (i=this.mLeftBounds + this.mDefaultSpriteSize / 2; i <= this.mRightBounds - this.mDefaultSpriteSize / 2; i = i + this.mDefaultSpriteSize)
		{ 	
			mPositionXArray.push(i);	
		}
	
		for (i=this.mTopBounds + this.mDefaultSpriteSize / 2; i <= this.mBottomBounds - this.mDefaultSpriteSize / 2; i = i + this.mDefaultSpriteSize)
		{ 	
			mPositionYArray.push(i);	
		}
	},

	createShapes: function()
	{
		//control object	
		new Shape(this,this.mIdCount,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,0,0,true,false,"",true,true,false,false,"","blue","");
		this.mIdCount++;
		for (i = this.mStartNumber + this.mCountBy; i <= this.mEndNumber; i = i + this.mCountBy)
		{
			this.setUniqueSpawnPosition();
			new Shape(this,this.mIdCount,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,mPositionXArray[this.mProposedX],mPositionYArray[this.mProposedY],false,true,i,true,true,false,false,"","yellow","");
			this.mIdCount++;
		}

		for (i = 0; i < this.mNumberOfChasers; i++)
		{
			this.setUniqueSpawnPosition();
			new Shape(this,this.mIdCount,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,mPositionXArray[this.mProposedX],mPositionYArray[this.mProposedY],false,true,"",true,true,true,false,"","red","");
			this.mIdCount++;	
			
		}

		//control buttons	
		new Shape(this,this.mIdCount,"",100,100,-200,0,false,false,"",false,false,false,true,"","",moveLeft);
		this.mIdCount++;
		new Shape(this,this.mIdCount,"",100,100,200,0,false,false,"",false,false,false,true,"","",moveRight);
		this.mIdCount++;
		new Shape(this,this.mIdCount,"",100,100,0,-200,false,false,"",false,false,false,true,"","",moveUp);
		this.mIdCount++;
		new Shape(this,this.mIdCount,"",100,100,0,200,false,false,"",false,false,false,true,"","",moveDown);
		this.mIdCount++;
		new Shape(this,this.mIdCount,"",100,100,0,0,false,false,"",false,false,false,true,"","",moveStop);
		this.mIdCount++;
	},

	setUniqueSpawnPosition: function()
	{
		//get random spawn element
		this.mProposedX = Math.floor(Math.random()*mPositionXArray.length);
		this.mProposedY = Math.floor(Math.random()*mPositionYArray.length);

		for (r= 0; r < this.mShapeArray.length; r++)
		{
			if (mPositionXArray[this.mProposedX] == this.mShapeArray[r].mPositionX && mPositionYArray[this.mProposedY] == this.mShapeArray[r].mPositionY)
			{
				r = 0;
				this.mProposedX = Math.floor(Math.random()*mPositionXArray.length);
				this.mProposedY = Math.floor(Math.random()*mPositionYArray.length);
			}
			if (r > 0)
			{	
				if (
			    	Math.abs(mPositionXArray[this.mProposedX] - this.mShapeArray[r-1].mPositionX) > 350 
					||
		            	Math.abs(mPositionYArray[this.mProposedY] - this.mShapeArray[r-1].mPositionY) > 350			
			   	) 
				{
					r = 0;
					this.mProposedX = Math.floor(Math.random()*mPositionXArray.length);
					this.mProposedY = Math.floor(Math.random()*mPositionYArray.length);
				}
				if (
			    	Math.abs(mPositionXArray[this.mProposedX] - this.mControlObject.mPositionX) < 100 
				 	&& 
		            	Math.abs(mPositionYArray[this.mProposedY] - this.mControlObject.mPositionY) < 100			
			   	) 
				{
					r = 0;
					this.mProposedX = Math.floor(Math.random()*mPositionXArray.length);
					this.mProposedY = Math.floor(Math.random()*mPositionYArray.length);
				}
			
			}
		}
	},
	

	createLeftWall: function()
	{
        	for (i=-275; i <= 275; i = i + this.mDefaultSpriteSize)
		{
			new Shape(this,this.mIdCount,"",1,this.mDefaultSpriteSize,this.mLeftBounds,i,false,false,"",true,true,false,false,"","black","");
			this.mIdCount++;
		}
	},

	createRightWall: function()
	{
       		var greenDoorCount = 0; 
		for (i=-275; i <= 275; i = i + this.mDefaultSpriteSize)
		{
			if (greenDoorCount == 0 || greenDoorCount == 1)
			{
				new Shape(this,this.mIdCount,"",1,this.mDefaultSpriteSize,this.mRightBounds,i,false,false,"",true,true,false,false,"","green","");
				this.mIdCount++;
			}	
			else
			{	
				new Shape(this,this.mIdCount,"",1,this.mDefaultSpriteSize,this.mRightBounds,i,false,false,"",true,true,false,false,"","black","");
				this.mIdCount++;
			}
			greenDoorCount++;
		}
	
	},

	createTopWall: function()
	{
        	for (i=-375; i <= 375; i = i + this.mDefaultSpriteSize)
		{
			new Shape(this,this.mIdCount,"",this.mDefaultSpriteSize,1,i,this.mTopBounds,false,false,"",true,true,false,false,"","black","");
			this.mIdCount++;
		}
	},

	createBottomWall: function()
	{
       		for (i=-375; i <= 375; i = i + this.mDefaultSpriteSize)
		{
			new Shape(this,this.mIdCount,"",this.mDefaultSpriteSize,1,i,this.mBottomBounds,false,false,"",true,true,false,false,"","black","");
			this.mIdCount++;
		}
	},
	
	moveShapes: function()
	{
        	//move numbers
        	for (i = 0; i < this.mShapeArray.length; i++)
        	{
			//update Velocity
			this.mShapeArray[i].mVelocityX = this.mShapeArray[i].mKeyX * this.mApplication.mTimeSinceLastInterval * this.mSpeed;
			this.mShapeArray[i].mVelocityY = this.mShapeArray[i].mKeyY * this.mApplication.mTimeSinceLastInterval * this.mSpeed;

			//update position
			this.mShapeArray[i].mPositionX += this.mShapeArray[i].mVelocityX;
			this.mShapeArray[i].mPositionY += this.mShapeArray[i].mVelocityY;
        	}
	}
});

function init()
{
	mApplication = new Application(<?php echo "$tickLength);"; ?>
	mApplication.update();
}

function ai()
{
	for (i = 0; i < mGame.mShapeArray.length; i++)
	{
		if (mGame.mShapeArray[i].mAI == true)
		{
			var direction = Math.floor(Math.random()*9)	
	                if (direction == 0) //left
                        {
                                mGame.mShapeArray[i].mKeyX = -1;
                                mGame.mShapeArray[i].mKeyY = 0;
                        }
                        if (direction == 1) //right
                        {
                                mGame.mShapeArray[i].mKeyX = 1;
                                mGame.mShapeArray[i].mKeyY = 0;
                        }
                        if (direction == 2) //up
                        {
                                mGame.mShapeArray[i].mKeyX = 0;
                                mGame.mShapeArray[i].mKeyY = -1;
                        }
                        if (direction == 3) //down
                        {
                                mGame.mShapeArray[i].mKeyX = 0;
                                mGame.mShapeArray[i].mKeyY = 1;
                        }
                        if (direction == 4) //leftup
                        {
                                mGame.mShapeArray[i].mKeyX = -.5;
                                mGame.mShapeArray[i].mKeyY = -.5;
                        }
                        if (direction == 5) //leftdown
                        {
                                mGame.mShapeArray[i].mKeyX = -.5;
                                mGame.mShapeArray[i].mKeyY = .5;
                        }
                        if (direction == 6) //rightup
                        {
                                mGame.mShapeArray[i].mKeyX = .5;
                                mGame.mShapeArray[i].mKeyY = -.5;
                        }
                        if (direction == 7) //rightdown
                        {
                                mGame.mShapeArray[i].mKeyX = .5;
                                mGame.mShapeArray[i].mKeyY = .5;
                        }
                        if (direction == 8) //stop
                        {
                                mGame.mShapeArray[i].mKeyX = 0;
                                mGame.mShapeArray[i].mKeyY = 0;
                        }
	
		} 
	}
}






function saveOldPositions()
{
        //move numbers
        for (i = 0; i < mGame.mShapeArray.length; i++)
        {
                //record old position to use for collisions or whatever you fancy
                mGame.mShapeArray[i].mOldPositionX = mGame.mShapeArray[i].mPositionX;
                mGame.mShapeArray[i].mOldPositionY = mGame.mShapeArray[i].mPositionY;
        }
}




function checkForCollisions()
{
	for (s = 0; s < mGame.mShapeArray.length; s++)
	{
	       	var x1 = mGame.mShapeArray[s].mPositionX;
	       	var y1 = mGame.mShapeArray[s].mPositionY;
 
		for (i = 0; i<mGame.mShapeArray.length; i++)
       		{
			if (mGame.mShapeArray[i] == mGame.mShapeArray[s])
			{
				//skip
			}
			else
			{
				if (mGame.mShapeArray[i].mCollisionOn == true && mGame.mShapeArray[s].mCollisionOn == true)
                		{
                        		var x2 = mGame.mShapeArray[i].mPositionX;              
                     			var y2 = mGame.mShapeArray[i].mPositionY;              
                
                        		var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                        		if (distSQ < mGame.mCollisionDistance) 
                        		{
						evaluateCollision(mGame.mShapeArray[s].mId,mGame.mShapeArray[i].mId);		      
                        		}
				}
                	}       
        	}
	}
}


window.onresize = function(event)
{
	mGame.mWindow = window.getSize();
}

//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
        //loop thru player array and update their xy positions
        for (i=0; i<mGame.mShapeArray.length; i++)
        {
		//get the center of the page xy
       		var pageCenterX = mGame.mWindow.x / 2;
        	var pageCenterY = mGame.mWindow.y / 2;
      
       		//get the center xy of the image
       		var shapeCenterX = mGame.mShapeArray[i].mWidth / 2;     
       		var shapeCenterY = mGame.mShapeArray[i].mHeight / 2;     

		//if control object center it on screen
		if (mGame.mShapeArray[i] == mGame.mControlObject || mGame.mShapeArray[i].mGui == true)
		{
			//shift the position based on pageCenterXY and shapeCenterXY	
        		var posX = pageCenterX - shapeCenterX;     
        		var posY = pageCenterY - shapeCenterY;     
			
			if (mGame.mShapeArray[i] == mGame.mControlObject)
			{
				//this actual moves it  
        			mGame.mShapeArray[i].mDiv.style.left = posX+'px';
        			mGame.mShapeArray[i].mDiv.style.top  = posY+'px';
			}
			else if (mGame.mShapeArray[i].mGui == true)
			{
				
				//we also need to resize gui based on size...
        			//button.style.width=mGame.mShapeArray[i].mWidth+'px'; 
        			//button.style.height=mGame.mShapeArray[i].mHeight+'px'; 
				
				//get the new size....
        			mGame.mShapeArray[i].mWidth = mGame.mWindow.x / 3;
        			mGame.mShapeArray[i].mHeight = mGame.mWindow.y / 3;

				if (mGame.mShapeArray[i].mInnerHTML == "DOWN")
				{
					mGame.mShapeArray[i].mHeight = mGame.mShapeArray[i].mHeight - 13;
				}
				
				mGame.mShapeArray[i].mMesh.style.width=mGame.mShapeArray[i].mWidth+'px'; 
        			mGame.mShapeArray[i].mMesh.style.height=mGame.mShapeArray[i].mHeight+'px'; 
					

				//now get the position
				if (mGame.mShapeArray[i].mOnClick == moveLeft)
				{
					mGame.mShapeArray[i].mPositionX = 0; 
					mGame.mShapeArray[i].mPositionY = mGame.mWindow.y / 2 - shapeCenterY; 
				}
				if (mGame.mShapeArray[i].mOnClick == moveRight)
				{
					var tempx = mGame.mWindow.x / 6;
					tempx = mGame.mWindow.x - tempx;
					
					mGame.mShapeArray[i].mPositionX = tempx - shapeCenterX; 
					mGame.mShapeArray[i].mPositionY = mGame.mWindow.y / 2 - shapeCenterY; 
				}
				if (mGame.mShapeArray[i].mOnClick == moveUp)
				{
					mGame.mShapeArray[i].mPositionX = mGame.mWindow.x / 2 - shapeCenterX; 
					mGame.mShapeArray[i].mPositionY = 0; 
				}
				if (mGame.mShapeArray[i].mOnClick == moveDown)
				{
					mGame.mShapeArray[i].mPositionX = mGame.mWindow.x / 2 - shapeCenterX; 
					
					var tempy = mGame.mWindow.y / 6;
					tempy = mGame.mWindow.y - tempy;
					mGame.mShapeArray[i].mPositionY = tempy - shapeCenterY - 13; 
					
				}
				if (mGame.mShapeArray[i].mOnClick == moveStop)
				{
					mGame.mShapeArray[i].mPositionX = mGame.mWindow.x / 2 - shapeCenterX; 
					mGame.mShapeArray[i].mPositionY = mGame.mWindow.y / 2 - shapeCenterY; 
				}
 
        			mGame.mShapeArray[i].mDiv.style.left = mGame.mShapeArray[i].mPositionX+'px';
        			mGame.mShapeArray[i].mDiv.style.top  = mGame.mShapeArray[i].mPositionY+'px';
				
			}
		} 
		
		//else if anything else render relative to the control object	
		else
		{
			//get the offset from control object
			var xdiff = mGame.mShapeArray[i].mPositionX - mGame.mControlObject.mPositionX;  
                	var ydiff = mGame.mShapeArray[i].mPositionY - mGame.mControlObject.mPositionY;  

                	//center image relative to position
                	var posX = xdiff + pageCenterX - shapeCenterX;
                	var posY = ydiff + pageCenterY - shapeCenterY;    
			
			//if off screen then hide it so we don't have scroll bars mucking up controls 
                        if (posX + mGame.mShapeArray[i].mWidth  + 3 > mGame.mWindow.x ||
			    posY + mGame.mShapeArray[i].mHeight + 13 > mGame.mWindow.y)
			{
                		mGame.mShapeArray[i].mDiv.style.left = 0+'px';
                       		mGame.mShapeArray[i].mDiv.style.top  = 0+'px';
				mGame.mShapeArray[i].mDiv.style.visibility = 'hidden';	
			}
			else //within dimensions..and still collidable(meaning a number that has been answered) or not a question at all
			{
				if (mGame.mShapeArray[i].mCollisionOn || 
				    mGame.mShapeArray[i].mIsQuestion == 'false')
				{	
                			mGame.mShapeArray[i].mDiv.style.left = posX+'px';
                       			mGame.mShapeArray[i].mDiv.style.top  = posY+'px';
					mGame.mShapeArray[i].mDiv.style.visibility = 'visible';	
				}
				else
				{
                			mGame.mShapeArray[i].mDiv.style.left = 0+'px';
                       			mGame.mShapeArray[i].mDiv.style.top  = 0+'px';
					mGame.mShapeArray[i].mDiv.style.visibility = 'hidden';	
				}
			}
		}
        }
}

//Score
function printScore()
{
        document.getElementById("score").innerHTML="Score: " + mGame.mScore;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + mGame.mScoreNeeded;
}

function checkForScoreNeeded()
{
        if (mGame.mScore == mGame.mScoreNeeded)
        {
		//open the doors
		for (i=0; i < mGame.mShapeArray.length; i++)
		{
			if (mGame.mShapeArray[i].mBackgroundColor == 'green')
			{
				mGame.mShapeArray[i].mBackgroundColor = 'white';
				mGame.mShapeArray[i].mDiv.style.backgroundColor = 'white';
			}
		}
	}
}

function checkForDoorEntered()
{
        if (mGame.mScore == mGame.mScoreNeeded)
        {
		if (mGame.mControlObject.mPositionX > mGame.mRightBounds - mGame.mDefaultSpriteSize / 2 &&
		    mGame.mControlObject.mPositionY > mGame.mTopBounds &&
		    mGame.mControlObject.mPositionY < mGame.mTopBounds + mGame.mDefaultSpriteSize * 2) 
		    	
		{
			mGame.mGameOn = false;
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
        for (i=0; i<mGame.mShapeArray.length; i++)
        {
         
		//set every shape to spawn position	
		mGame.mShapeArray[i].mPositionX = mGame.mShapeArray[i].mSpawnPositionX;
		mGame.mShapeArray[i].mPositionY = mGame.mShapeArray[i].mSpawnPositionY;

	      	if (mGame.mShapeArray[i].mCollidable == true)
		{ 
			mGame.mShapeArray[i].mCollisionOn = true;
                	mGame.mShapeArray[i].mDiv.style.visibility = 'visible';
		}
        }
	mGame.mControlObject.mPositionX = 0;     
	mGame.mControlObject.mPositionY = 0;     
 
        //score
        mGame.mScore = 0;

        //game
        mGame.mQuestion = mGame.mCount;

        //count
        mGame.mCount = mGame.mStartNumber;
        
	//answer
	newAnswer();
        mGame.mShapeArray[0].mMesh.innerHTML=mGame.mCount;
}

//check guess
function evaluateCollision(mId1,mId2)
{
	if (mGame.mShapeArray[mId1] == mGame.mControlObject)
	{

		if (mGame.mShapeArray[mId2].mIsQuestion)
		{
        		if (mGame.mShapeArray[mId2].mAnswer == mGame.mAnswer)
        		{
                		mGame.mCount = mGame.mCount + mGame.mCountBy;  //add to count
                		mGame.mScore++;
				mGame.mShapeArray[mId2].mCollisionOn = false;
				mGame.mShapeArray[mId2].mDiv.style.visibility = 'hidden';
                
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
			mGame.mShapeArray[mId1].mPositionX = mGame.mShapeArray[mId1].mOldPositionX;
			mGame.mShapeArray[mId1].mPositionY = mGame.mShapeArray[mId1].mOldPositionY;
		
			mGame.mShapeArray[mId2].mPositionX = mGame.mShapeArray[mId2].mOldPositionX;
			mGame.mShapeArray[mId2].mPositionY = mGame.mShapeArray[mId2].mOldPositionY;
		}
	}
	else
	{
		mGame.mShapeArray[mId1].mPositionX = mGame.mShapeArray[mId1].mOldPositionX;
		mGame.mShapeArray[mId1].mPositionY = mGame.mShapeArray[mId1].mOldPositionY;
		
		mGame.mShapeArray[mId2].mPositionX = mGame.mShapeArray[mId2].mOldPositionX;
		mGame.mShapeArray[mId2].mPositionY = mGame.mShapeArray[mId2].mOldPositionY;
	}
}

//questions
function newQuestion()
{
        //set question
        mGame.mQuestion = mGame.mCount;
        document.getElementById("question").innerHTML="Question: " + mGame.mQuestion;
        mGame.mShapeArray[0].mMesh.innerHTML=mGame.mCount;
}

//new answer
function newAnswer()
{
        mGame.mAnswer = mGame.mCount + mGame.mCountBy;
}

//CONTROLS
function moveLeft()
{
	mGame.mControlObject.mKeyX = -1;
        mGame.mControlObject.mKeyY = 0;
}

function moveRight()
{
        mGame.mControlObject.mKeyX = 1;
        mGame.mControlObject.mKeyY = 0;
}

function moveUp()
{
        mGame.mControlObject.mKeyX = 0;
        mGame.mControlObject.mKeyY = -1;
}

function moveDown()
{
        mGame.mControlObject.mKeyX = 0;
        mGame.mControlObject.mKeyY = 1;
}

function moveStop()
{
        mGame.mControlObject.mKeyX = 0;
        mGame.mControlObject.mKeyY = 0;
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
                mApplication.mKeyLeft = true;
        }
        if (event.key == 'right')
        {
                mApplication.mKeyRight = true;
        }
        if (event.key == 'up')
        {
                mApplication.mKeyUp = true;
        }
        if (event.key == 'down')
        {
                mApplication.mKeyDown = true;
        }
        if (event.key == 'space')
        {
                mApplication.mKeyStop = true;
        }
}

function onkeyup(event)
{
        if (event.key == 'left')
        {
                mApplication.mKeyLeft = false;
        }
        if (event.key == 'right')
        {
                mApplication.mKeyRight = false;
        }
        if (event.key == 'up')
        {
                mApplication.mKeyUp = false;
        }
        if (event.key == 'down')
        {
                mApplication.mKeyDown = false;
        }
        if (event.key == 'space')
        {
                mApplication.mKeyStop = false;
        }
}




</script>

</head>
<body>
<script type="text/javascript"> 
window.addEvent('domready', function()
{
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
