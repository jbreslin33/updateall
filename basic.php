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

var jScoreNeeded = <?php echo $scoreNeeded; ?>;

//application
var mApplication;

//game
var mGame;


</script>


<script type="text/javascript" src="src/shape/shape.php"></script>
<script type="text/javascript" src="src/shape/shape_gui.php"></script>
<script type="text/javascript" src="src/shape/shape_relative.php"></script>
<script type="text/javascript" src="src/shape/shape_controlobject.php"></script>


<script language="javascript">
//Application Class
var Application = new Class(
{
	initialize: function(tickLength)
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

		mGame = new Game(this, jScoreNeeded, <?php echo "$countBy, $startNumber, $endNumber, $numberOfChasers, $speed, $leftBounds, $rightBounds, $topBounds, $bottomBounds, $collisionDistance);"; ?>
		
		//this will be used for resetting to
		mGame.resetGame();

		g = new Date();
		mGameStartTime = g.getTime();
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
		
			//render();	
			
			var t=setTimeout("mApplication.update()",20)
		}
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
	},

	//CONTROLS
	moveLeft: function()
	{
		//alert('moveLeft');
		mGame.mControlObject.mKeyX = -1;
        	mGame.mControlObject.mKeyY = 0;
	},

	moveRight: function()
	{
        	mGame.mControlObject.mKeyX = 1;
        	mGame.mControlObject.mKeyY = 0;
	},

	moveUp: function()
	{
        	mGame.mControlObject.mKeyX = 0;
        	mGame.mControlObject.mKeyY = -1;
	},

	moveDown: function()
	{
        	mGame.mControlObject.mKeyX = 0;
        	mGame.mControlObject.mKeyY = 1;
	},

	moveStop: function()
	{
        	mGame.mControlObject.mKeyX = 0;
        	mGame.mControlObject.mKeyY = 0;
	},
	
	keyDown: function(event)
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
	},
	
	keyUp: function(event)
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
	}
});

//Game Class
var Game = new Class(
{
	initialize: function(application, jScoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
	{
		//application
		this.mApplication = application;	
		//On_Off
		this.mGameOn = true;
	
		//shapes
		this.mPositionXArray = new Array();
		this.mPositionYArray = new Array();

		this.mSlotPositionXArray = new Array();
		this.mSlotPositionYArray = new Array();
		
		//shape Array
		this.mShapeArray = new Array();
	
		//control object
		this.mControlObject;
		
		//window size
		this.mWindow = window.getSize();

		//score
      		this.mScore = 0; 
	 	this.mScoreNeeded = jScoreNeeded;

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
		//move shapes	
		for (i = 0; i < this.mShapeArray.length; i++)
		{
			this.mShapeArray[i].update();
		}
		
		//door entered?
		this.checkForDoorEntered();

		//reality check for out of bounds for avatar
		this.checkForOutOfBounds();
	
		//check collisions
       		this.checkForCollisions();
	
		//check for end game
		this.checkForScoreNeeded();
	
		//save old positions
		this.saveOldPositions();
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
			this.mPositionXArray.push(i);	
		}
	
		for (i=this.mTopBounds + this.mDefaultSpriteSize / 2; i <= this.mBottomBounds - this.mDefaultSpriteSize / 2; i = i + this.mDefaultSpriteSize)
		{ 	
			this.mPositionYArray.push(i);	
		}
	},

	createShapes: function()
	{
		//control object	
		new ShapeControlObject(this,this.mIdCount,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,0,0,true,false,"",true,true,false,false,"","blue","");
		this.mIdCount++;
		for (i = this.mStartNumber + this.mCountBy; i <= this.mEndNumber; i = i + this.mCountBy)
		{
			this.setUniqueSpawnPosition();
			new ShapeRelative(this,this.mIdCount,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],false,true,i,true,true,false,false,"","yellow","");
			this.mIdCount++;
		}

		for (i = 0; i < this.mNumberOfChasers; i++)
		{
			this.setUniqueSpawnPosition();
			new ShapeRelative(this,this.mIdCount,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],false,true,"",true,true,true,false,"","red","");
			this.mIdCount++;	
			
		}

		//control buttons	
		new ShapeGui(this,this.mIdCount,"",100,100,-200,0,false,false,"",false,false,false,true,"","",this.mApplication.moveLeft);
		this.mIdCount++;
		new ShapeGui(this,this.mIdCount,"",100,100,200,0,false,false,"",false,false,false,true,"","",this.mApplication.moveRight);
		this.mIdCount++;
		new ShapeGui(this,this.mIdCount,"",100,100,0,-200,false,false,"",false,false,false,true,"","",this.mApplication.moveUp);
		this.mIdCount++;
		new ShapeGui(this,this.mIdCount,"",100,100,0,200,false,false,"",false,false,false,true,"","",this.mApplication.moveDown);
		this.mIdCount++;
		new ShapeGui(this,this.mIdCount,"",100,100,0,0,false,false,"",false,false,false,true,"","",this.mApplication.moveStop);
		this.mIdCount++;
	},

	setUniqueSpawnPosition: function()
	{
		//get random spawn element
		this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
		this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);

		for (r= 0; r < this.mShapeArray.length; r++)
		{
			if (this.mPositionXArray[this.mProposedX] == this.mShapeArray[r].mPositionX && this.mPositionYArray[this.mProposedY] == this.mShapeArray[r].mPositionY)
			{
				r = 0;
				this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
				this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
			}
			if (r > 0)
			{	
				if (
			    	Math.abs(this.mPositionXArray[this.mProposedX] - this.mShapeArray[r-1].mPositionX) > 350 
					||
		            	Math.abs(this.mPositionYArray[this.mProposedY] - this.mShapeArray[r-1].mPositionY) > 350			
			   	) 
				{
					r = 0;
					this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
					this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
				}
				if (
			    	Math.abs(this.mPositionXArray[this.mProposedX] - this.mControlObject.mPositionX) < 100 
				 	&& 
		            	Math.abs(this.mPositionYArray[this.mProposedY] - this.mControlObject.mPositionY) < 100			
			   	) 
				{
					r = 0;
					this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
					this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
				}
			
			}
		}
	},
	

	createLeftWall: function()
	{
        	for (i=-275; i <= 275; i = i + this.mDefaultSpriteSize)
		{
			new ShapeRelative(this,this.mIdCount,"",1,this.mDefaultSpriteSize,this.mLeftBounds,i,false,false,"",true,true,false,false,"","black","");
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
				new ShapeRelative(this,this.mIdCount,"",1,this.mDefaultSpriteSize,this.mRightBounds,i,false,false,"",true,true,false,false,"","green","");
				this.mIdCount++;
			}	
			else
			{	
				new ShapeRelative(this,this.mIdCount,"",1,this.mDefaultSpriteSize,this.mRightBounds,i,false,false,"",true,true,false,false,"","black","");
				this.mIdCount++;
			}
			greenDoorCount++;
		}
	
	},

	createTopWall: function()
	{
        	for (i=-375; i <= 375; i = i + this.mDefaultSpriteSize)
		{
			new ShapeRelative(this,this.mIdCount,"",this.mDefaultSpriteSize,1,i,this.mTopBounds,false,false,"",true,true,false,false,"","black","");
			this.mIdCount++;
		}
	},

	createBottomWall: function()
	{
       		for (i=-375; i <= 375; i = i + this.mDefaultSpriteSize)
		{
			new ShapeRelative(this,this.mIdCount,"",this.mDefaultSpriteSize,1,i,this.mBottomBounds,false,false,"",true,true,false,false,"","black","");
			this.mIdCount++;
		}
	},

	saveOldPositions: function()
	{
        	//save old positions
        	for (i = 0; i < this.mShapeArray.length; i++)
        	{
                	//record old position to use for collisions or whatever you fancy
                	this.mShapeArray[i].mOldPositionX = this.mShapeArray[i].mPositionX;
                	this.mShapeArray[i].mOldPositionY = this.mShapeArray[i].mPositionY;
        	}
	},

	checkForCollisions: function()
	{
		for (s = 0; s < this.mShapeArray.length; s++)
		{
	       		var x1 = this.mShapeArray[s].mPositionX;
	       		var y1 = this.mShapeArray[s].mPositionY;
 
			for (i = 0; i < this.mShapeArray.length; i++)
       			{
				if (this.mShapeArray[i] == this.mShapeArray[s])
				{
					//skip
				}
				else
				{
					if (this.mShapeArray[i].mCollisionOn == true && this.mShapeArray[s].mCollisionOn == true)
                			{
                        			var x2 = this.mShapeArray[i].mPositionX;              
                     				var y2 = this.mShapeArray[i].mPositionY;              
                
                        			var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                        			if (distSQ < this.mCollisionDistance) 
                        			{
							this.evaluateCollision(this.mShapeArray[s].mId,this.mShapeArray[i].mId);		      
                        			}
					}
                		}       
        		}
		}
	},

	//questions
	newQuestion: function()
	{
        	//set question
        	this.mQuestion = this.mCount;
        	document.getElementById("question").innerHTML="Question: " + this.mQuestion;
        	this.mShapeArray[0].mMesh.innerHTML=this.mCount;
	},

	//new answer
	newAnswer: function()
	{
        	this.mAnswer = this.mCount + this.mCountBy;
	},

	evaluateCollision: function(mId1,mId2)
	{
		if (this.mShapeArray[mId1] == this.mControlObject)
		{

			if (this.mShapeArray[mId2].mIsQuestion)
			{
        			if (this.mShapeArray[mId2].mAnswer == this.mAnswer)
        			{
                			this.mCount = this.mCount + this.mCountBy;  //add to count
                			this.mScore++;
					this.mShapeArray[mId2].mCollisionOn = false;
					this.mShapeArray[mId2].mDiv.style.visibility = 'hidden';
                
                			//feedback      
                			document.getElementById("feedback").innerHTML="Correct!";
        			}
        			else
        			{
                			//feedback 
                			document.getElementById("feedback").innerHTML="Wrong! Try again.";
        
                			//this deletes and then recreates everthing.    
                			this.resetGame();
        			}
    				this.newQuestion();
        			this.newAnswer();
        			this.printScore();
			}
			else
			{
				this.mShapeArray[mId1].mPositionX = this.mShapeArray[mId1].mOldPositionX;
				this.mShapeArray[mId1].mPositionY = this.mShapeArray[mId1].mOldPositionY;
		
				this.mShapeArray[mId2].mPositionX = this.mShapeArray[mId2].mOldPositionX;
				this.mShapeArray[mId2].mPositionY = this.mShapeArray[mId2].mOldPositionY;
			}
		}
		else
		{
			this.mShapeArray[mId1].mPositionX = this.mShapeArray[mId1].mOldPositionX;
			this.mShapeArray[mId1].mPositionY = this.mShapeArray[mId1].mOldPositionY;
		
			this.mShapeArray[mId2].mPositionX = this.mShapeArray[mId2].mOldPositionX;
			this.mShapeArray[mId2].mPositionY = this.mShapeArray[mId2].mOldPositionY;
		}
	},

	//Score
	printScore: function()
	{
        	document.getElementById("score").innerHTML="Score: " + this.mScore;
        	document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.mScoreNeeded;
	},

	checkForScoreNeeded: function()
	{
        	if (this.mScore == this.mScoreNeeded)
        	{
			//open the doors
			for (i=0; i < this.mShapeArray.length; i++)
			{
				if (this.mShapeArray[i].mBackgroundColor == 'green')
				{
					this.mShapeArray[i].mBackgroundColor = 'white';
					this.mShapeArray[i].mDiv.style.backgroundColor = 'white';
				}
			}
		}
	},

	checkForDoorEntered: function()
	{
        	if (this.mScore == this.mScoreNeeded)
        	{
			if (this.mControlObject.mPositionX > this.mRightBounds - this.mDefaultSpriteSize / 2 &&
		    	this.mControlObject.mPositionY > this.mTopBounds &&
		    	this.mControlObject.mPositionY < this.mTopBounds + this.mDefaultSpriteSize * 2) 
		    	
			{
				this.mGameOn = false;
                		document.getElementById("feedback").innerHTML="YOU WIN!!!";
                		window.location = "goto_next_math_level.php"
			}
        	}
	},

	//reset
	resetGame: function()
	{
 		//set collidable to true 
        	for (i=0; i < this.mShapeArray.length; i++)
        	{
         
			//set every shape to spawn position	
			this.mShapeArray[i].mPositionX = this.mShapeArray[i].mSpawnPositionX;
			this.mShapeArray[i].mPositionY = this.mShapeArray[i].mSpawnPositionY;

	      		if (this.mShapeArray[i].mCollidable == true)
			{ 
				this.mShapeArray[i].mCollisionOn = true;
                		this.mShapeArray[i].mDiv.style.visibility = 'visible';
			}
        	}
		this.mControlObject.mPositionX = 0;     
		this.mControlObject.mPositionY = 0;     
 
        	//score
        	this.mScore = 0;

        	//game
        	this.mQuestion = this.mCount;

        	//count
        	this.mCount = this.mStartNumber;
        
		//answer
		this.newAnswer();
        	this.mShapeArray[0].mMesh.innerHTML=this.mCount;
	}
});

window.onresize = function(event)
{
	mGame.mWindow = window.getSize();
}

</script>

</head>
<body>
<script type="text/javascript"> 
window.addEvent('domready', function()
{
	//the application
	mApplication = new Application(<?php echo "$tickLength);"; ?>

	
	//keys	
	document.addEvent("keydown", mApplication.keyDown);
	document.addEvent("keyup", mApplication.keyUp);

	//start updating	
	mApplication.update();
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
