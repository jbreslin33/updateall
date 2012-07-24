/******************************************
public methods
-----------------

PUBLIC
---------------------------

//set methods

//get methods
controlObject getControlObject();

PRIVATE
---------------------------------

//add methods
void          addToShapeArray          (shape);
void 	      setFeedback(feedback);

***************************************/

var Game = new Class(
{
        initialize: function(skill)
        {
		/************ NAME *******/
		this.mSkill = skill;

		/************** On_Off **********/
                this.mOn = true;
                
		/**************** TIME ************/
                this.mTimeSinceEpoch = 0;
                this.mLastTimeSinceEpoch = 0;
                this.mDeltaTime = 0;

		/********* SHAPES *******************/ 
		//control object
                this.mControlObject;
                
		//shape Array
                this.mShapeArray = new Array();
        },

	quizComplete: function()
	{
	
	},

        correctAnswer: function(col1,col2)
        {
		if (this.mQuiz)
                {
                	this.mQuiz.correctAnswer();
                }

                col2.mCollisionOn = false;
                col2.setVisibility(false);

                //set text of control object
                if (this.mQuiz)
                {
                	//set the control objects question object
                        col1.setQuestion(this.mQuiz.getQuestion());
                        if (col1.mMountee)
                        {
                        	col1.mMountee.setQuestion(this.mQuiz.getQuestion());
                        }
                }
        },

        incorrectAnswer: function(col1,col2)
        {
		this.resetGame();
        },

 	resetGame: function()
        {
		if (this.mQuiz)
		{
			this.mQuiz.reset();
		}
                
		//reset collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
			this.mShapeArray[i].reset();
		}
	
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
                        
			//check Keys from application
			this.checkKeys();

                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
				this.mShapeArray[i].update(this.mDeltaTime);
				if (this.mShapeArray[i].mMounter)
				{
				}	
				else
				{	
					this.checkForOutOfBounds(this.mShapeArray[i]);
				}
				//this.checkForOutOfBounds(this.mShapeArray[i]);
                	}
			
			//collision Detection
			this.checkForCollisions();

                	for (i = 0; i < this.mShapeArray.length; i++)
			{
                        	this.mShapeArray[i].updateScreen();
			}	
        
                	//save old positions
                	this.saveOldPositions();
			//var t=setTimeout("mGame.update()",32)

			//check for quiz complete
                	if (this.mQuiz)
               		{
                        	if (this.mQuiz.isQuizComplete())
                        	{
					this.quizComplete();
                        	}
                	}
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
			if (this.mShapeArray[s].mCollidable ==  true && this.mShapeArray[s].mCollisionOn == true)
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
						if (this.mShapeArray[c].mCollidable ==  true && this.mShapeArray[c].mCollisionOn == true)
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
                                					this.evaluateCollision(this.mShapeArray[s],this.mShapeArray[c])
								}
                                			}
						}
					}
			   	}
			}
                }
	}).protect(),

	evaluateCollision: (function(col1,col2)
        {
		col1.mPosition.mX = col1.mPositionOld.mX;
		col1.mPosition.mY = col1.mPositionOld.mY;

		col2.mPosition.mX = col2.mPositionOld.mX;
		col2.mPosition.mY = col2.mPositionOld.mY;

		//mount an item if mountable
                if (col1.mMessage == "controlObject" && col2.mMountable == true)
		{
			if (col1 != col2.getTimeoutShape())
			{
				//first unmount  if you have something
				if (col1.mMountee)
				{
					col1.unMount(col1.mMountee,0);
				}
				//then mount	
				col1.mount(col2,0);	
			}
		}


		//if you get hit with a chaser then reset game or maybe lose a life
                if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
                        //this deletes and then recreates everthing.
                        this.hitByChaser();
                }

	 	//you ran into a question shape lets resolve it
                if (col1.mMessage == "controlObject" && col2.mMessage == "question")
                {
                        if (col1.mMountee)
                        {
                                if (col1.mMountee.mQuestion.getAnswer() == col2.mQuestion.getAnswer())
                                {
                                        this.correctAnswer(col1,col2);
                                }
                                else
                                {
                                        this.incorrectAnswer(col1,col2);
                                }
                        }
                }

 		//a dropbox_question recieving a pickup from a control object
                if (col1.mMessage == "controlObject" && col2.mMessage == "dropbox_question")
                {
                        //check for correct answer
                        if (col1.mMountee)
                        {
				if (col1.mMountee.mQuestion && col2.mQuestion)
				{
                                	if (col1.mMountee.mQuestion.getAnswer() == col2.mQuestion.getAnswer())
                                	{
						this.correctAnswer(col1,col2);
                                	}
                                	else
                                	{
                                        	//this deletes and then recreates everthing.
                                        	this.incorrectAnswer(col1,col2);
                                	}
				}
                        }
  		
			//have the dropbox_question pick up the pickup from controlobject	
			pickup = 0;
			if (col1.mMountee)
			{
                        	if (col1.mMountee.mMessage == "pickup")
                        	{
                                	pickup = col1.mMountee;

                                	//have controlObject unMount pickup
                                	col1.unMount();

                                	//have dropbox_question mount pickup
					//ie is showing this too high
                                	if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
                                	{
                                        	col2.mount(pickup,-5,-41);
                                	}
                                	else
                                	{
                                        	col2.mount(pickup,-5,-58);
                                	}
                        	}
			}
		}

		//exit room to next level when you complete quiz
                if (col1.mMessage == "controlObject" && col2.mMessage == "door")
                {
			//col1.onCollision(col2);
			col2.onCollision(col1);
/*	
			if (col2.mOpen)
			{
                                if (this.mQuiz)
                                {
                                        if (this.mQuiz.isQuizComplete())
                                        {
						this.enterDoor(col2);
                                        }
				}	
			}
*/
                }


	}).protect(),
   
	enterDoor: function(door)
        {
                this.mOn = false;
                window.location = door.getQuestion().getAnswer(); 
        },

	pickup: function(col1,col2)
	{
        	if (col1.mMountee.mMessage == "pickup")
        	{
                	col1.unMount();
                }

               	//do the mount
                //ie is showing this too high
                if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
                {
                        col1.mount(col2,-5,-41);
                }
                else
                {
                        col1.mount(col2,-5,-58);
               	}
	},

	hitByChaser: function()
	{
		this.resetGame();
	},

	checkForOutOfBounds: function(shape)
	{
		if (shape.mPosition.mY < mBounds.mNorth)
		{
			shape.mPosition.mY = mBounds.mNorth;
		}	
		if (shape.mPosition.mX > mBounds.mEast)
		{
			shape.mPosition.mX = mBounds.mEast;
		}	
		if (shape.mPosition.mY > mBounds.mSouth)
		{
			shape.mPosition.mY = mBounds.mSouth;
		}	
		if (shape.mPosition.mX < mBounds.mWest)
		{
			shape.mPosition.mX = mBounds.mWest;
		}	
	},

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
                                if (this.mShapeArray[s].mCollidable ==  true)
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
 
        }

});


