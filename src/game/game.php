<?php
session_start();
?>

var Game = new Class(
{

        initialize: function()
        {
		/************ SCORE *******/
		this.score  = 0;
		this.mScore = 0;

		/************** On_Off **********/
                this.mOn = true;
				
		// may get rid of later and just use mOn
		this.gameOver = false;
		this.timeWarning = false;
                
		/**************** TIME ************/
                this.mTimeSinceEpoch = 0;
                this.mLastTimeSinceEpoch = 0;
                this.mDeltaTime = 0;
		this.mGameTime = 0;

		/********* SHAPES *******************/ 
		//control object
                this.mControlObject;
                
		//shape Array
                this.mShapeArray = new Array();
			
		/********* BOUNDS *******************/ 
                //create bounds
                this.createBounds(60,735,380,35);

		/********* HUD *******************/ 
		//HUD
		this.mHud = 0;
        },
				
	//brian - update score in games_attempts table		
	updateScore: function()
	{
		if(this.gameOver == false)
		{
			var str = this.getScore();
			
			if (str == this.score)
			{
				return;
			}
			
			var xmlhttp;    
			
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
			  	xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
			  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
		  	{
			  
			}
			xmlhttp.open("GET","../../src/database/update_score.php?q="+str,true);
			xmlhttp.send();
			
			this.score = str;
		}
	},
	
	checkTime: function()
	{
		if (this.mGameTime > 10000 && this.timeWarning == false)
		{
			var xmlhttp;    
			
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				  
			}
			xmlhttp.open("GET","../../src/database/time_warning.php",true);
			xmlhttp.send();
			this.timeWarning = true;
		}
	},

	quizComplete: function()
	{	
	  	if(this.gameOver == false)
		{
			var xmlhttp;    
		
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
		  		xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
		  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
		  
			}
			xmlhttp.open("GET","../../src/database/set_game_end_time.php",true);
			xmlhttp.send();
		}
	},

 	resetGame: function()
        {
                
		//call reset on all shapes
                for (i=0; i < this.mShapeArray.length; i++)
                {
			this.mShapeArray[i].reset();
		}

		//reset score
		this.setScore(0);
        },

	/*********************** PUBLIC ***************************/
	getControlObject: function()
	{
		return this.mControlObject;
	},

	/**************** ADD METHODS *************/
	addToShapeArray: function(shape)
	{
		this.mShapeArray.push(shape);
	},
	
        update: function()
        {
                if (this.mOn)
                {
			//get time since epoch and set lasttime
                	e = new Date();
                	this.mLastTimeSinceEpoch = this.mTimeSinceEpoch;
                	this.mTimeSinceEpoch = e.getTime();

                	//set deltatime as function of timeSinceEpoch and LastTimeSinceEpoch diff
                	this.mDeltaTime = this.mTimeSinceEpoch - this.mLastTimeSinceEpoch;
					
			if(this.mDeltaTime < 50000)
			{
				this.mGameTime = this.mGameTime + this.mDeltaTime;
			}
                        
			//check Keys from application
			this.checkKeys();

                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
				this.mShapeArray[i].update(this.mDeltaTime);
                	}
			
			//collision Detection
			this.checkForCollisions();

                	for (i = 0; i < this.mShapeArray.length; i++)
			{
                        	this.mShapeArray[i].render();
			}	
        
                	//save old positions
                	this.saveOldPositions();
		}
        },

	/****************************** PROTECTED ***************************************/
	

	checkKeys: (function()
        {
                //idle
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = 0;
                }
                //north
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = -1;
                }
                //north_east
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = .5;
                        this.mControlObject.mKey.mY = -.5;
                }
                //east
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 1;
                        this.mControlObject.mKey.mY = 0;
                }
                //south_east
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = .5;
                        this.mControlObject.mKey.mY = .5;
                }
                //south
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = 1;
                }
                //south_west
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = -.5;
                        this.mControlObject.mKey.mY = .5;
                }
                //west
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = -1;
                        this.mControlObject.mKey.mY = 0;
                }
                //north_west
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = -.5;
                        this.mControlObject.mKey.mY = -.5;
                }
        }).protect(),

        saveOldPositions: (function()
        {
                //save old positions
                for (i = 0; i < this.mShapeArray.length; i++)
                {
                        //record old position to use for collisions or whatever you fancy
                        this.mShapeArray[i].mPositionOld.mX = this.mShapeArray[i].mPosition.mX;
                        this.mShapeArray[i].mPositionOld.mY = this.mShapeArray[i].mPosition.mY;
                        this.mShapeArray[i].mPositionRenderOld.mX = this.mShapeArray[i].mPositionRender.mX;
                        this.mShapeArray[i].mPositionRenderOld.mY = this.mShapeArray[i].mPositionRender.mY;
                }
        }).protect(),

	//this is still ineffiecient because it is checking to see if one coin is colliding with another. when neither is moving.	
	checkForCollisions: (function()
        {
                for (s = 0; s < this.mShapeArray.length; s++)
                {
			if (this.mShapeArray[s].mCollisionOn == true)
			{
			   	//this should now only loop the first for loop thru objects that have moved. which i think will improve efficiency 
			    	if (this.mShapeArray[s].mPosition.mX != this.mShapeArray[s].mPositionOld.mX ||
			        this.mShapeArray[s].mPosition.mY != this.mShapeArray[s].mPositionOld.mY)
			    	{
					for (c = 0; c < this.mShapeArray.length; c++)
					{
						if (this.mShapeArray[c] == this.mShapeArray[s])
						{
							continue;
						}
						if (this.mShapeArray[c].mCollisionOn == true)
						{
                        				var x1 = this.mShapeArray[s].mPosition.mX;
                        				var y1 = this.mShapeArray[s].mPosition.mY;

                        				var x2 = this.mShapeArray[c].mPosition.mX;
                        				var y2 = this.mShapeArray[c].mPosition.mY;
                
                                			var addend1 = x1 - x2;
							addend1 = addend1 * addend1;

                                			var addend2 = y1 - y2;
							addend2 = addend2 * addend2;

                                			var distSQ = addend1 + addend2;
						
                                			var collisionDistance = this.mShapeArray[s].mCollisionDistance + this.mShapeArray[c].mCollisionDistance;
                                			if (distSQ < collisionDistance) 
                                			{
								if (this.mShapeArray[s].getTimeoutShape() != this.mShapeArray[c] && this.mShapeArray[c].getTimeoutShape() != this.mShapeArray[s])
								{
									this.mShapeArray[c].onCollision(this.mShapeArray[s]);	
									this.mShapeArray[s].onCollision(this.mShapeArray[c]);	
								}
                                			}
						}
					}
			   	}
			}
                }
	}).protect(),
	
	getOpenPoint2D: function(xMin,xMax,yMin,yMax,newShapeWidth,spreadFactor)
        {
                while (true)
                {
                        //let's get a random open space...
                        //get the size of the playing field
                        var xSize = xMax - xMin;
                        var ySize = yMax - yMin;

                        //get point that would fall in the size range from above
                        var randomPoint2D = new Point2D( Math.floor( Math.random()*xSize) , Math.floor(Math.random()*ySize));

                        //now add the left and top bounds so that it is on the games actual field
                        randomPoint2D.mX += xMin;
                        randomPoint2D.mY += yMin;

                        //we now need to see if we can make it thru all shapes without a collision
                        var isCollision = false;
                        for (s = 0; s < this.mShapeArray.length; s++)
                        {
                                if (this.mShapeArray[s].mCollidable == true)
                                {
 					var x1 = this.mShapeArray[s].mPosition.mX;
                                        var y1 = this.mShapeArray[s].mPosition.mY;
 
                                        var x2 = randomPoint2D.mX;              
                                        var y2 = randomPoint2D.mY;              
                
                                        var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                                        var collisionDistanceOfNewShape = newShapeWidth * 6.5;
                                        var collisionDistance = (this.mShapeArray[s].mCollisionDistance + collisionDistanceOfNewShape) * spreadFactor;
                                                
                                        if (distSQ < collisionDistance) 
                                        {
                                                isCollision = true; 
                                        }
                                }
                        }
                        
                        //we have an open point 
                        if (isCollision == false)
                        {
                                return randomPoint2D;
                        }
                } 
        },

  	createBounds: function(north,east,south,west)
        {
                mBounds = new Bounds(north,east,south,west);
        },

        getScore: function()
        {
                return this.mScore;
        },

        setScore: function(score)
        {
                this.mScore = score;
                this.mHud.mScore.setText('<font size="2">Score: ' + this.mScore + '</font>');
        },

        incrementScore: function()
        {
                this.mScore++;
                this.mHud.mScore.setText('<font size="2"> Score : ' + this.mScore + '</font>');
        },

	setHud: function(hud)
	{
		this.mHud = hud;
	},

	getHud: function()
	{
		return this.mHud;
	}

});


