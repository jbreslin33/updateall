var Game = new Class(
{

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds)
        {
		/************ NAME *******/
		this.mName = name;

		/************ DIMENSIONS *******/
                this.mLeftBounds = leftBounds;
                this.mRightBounds = rightBounds;
                this.mTopBounds = topBounds;
                this.mBottomBounds = bottomBounds;
		
		/************** On_Off **********/
                this.mOn = true;
                
		/**************** TIME ************/
                this.mTimeSinceEpoch = 0;
                this.mLastTimeSinceEpoch = 0;
                this.mTimeSinceLastInterval = 0;

		/************ HUD **********************/
		this.mHud = new Hud(this);
		this.mHud.createHud();
	        
		/********************** QUIZ **************/
                this.mQuiz;
               	
		/********* SHAPES *******************/ 
                // id counter
                this.mIdCount = 0;
		
		//control object
                this.mControlObject;
                
		//shape Array
                this.mShapeArray = new Array();

		//collidable shape array
                this.mShapeCollidableArray = new Array();
	        
                //shapes
                this.mPositionXArray = new Array();
                this.mPositionYArray = new Array();

                this.mSlotPositionXArray = new Array();
                this.mSlotPositionYArray = new Array();
                
                //proposed positions    
                this.mProposedX = 0;
                this.mProposedY = 0;

                //fill possible spawnPosition Arrays
                this.fillSpawnPositionArrays();

        },

	getGame: function()
	{
		return this;
	},

        update: function()
        {
                if (this.mOn)
                {
			//get time since epoch and set lasttime
                	e = new Date();
                	this.mLastTimeSinceEpoch = this.mTimeSinceEpoch;
                	this.mTimeSinceEpoch = e.getTime();

                	//set timeSinceLastInterval as function of timeSinceEpoch and LastTimeSinceEpoch diff
                	this.mTimeSinceLastInterval = this.mTimeSinceEpoch - this.mLastTimeSinceEpoch;
                        
			//check Keys from application
			this.checkKeys();

                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
                        	this.mShapeArray[i].update(this.mTimeSinceLastInterval);
                	}

			//update hud
			this.mHud.update(0);
                
                	//reality check for out of bounds for avatar
                	this.checkForOutOfBounds();
        
                	//check collisions
                	this.checkForCollisions();
        
                	//check for end game
                	this.checkForScoreNeeded();
        
                	//save old positions
                	this.saveOldPositions();
			var t=setTimeout("mGame.update()",20)
                }
        },

	setQuiz: function(quiz)
	{
		this.mQuiz = quiz;
	},

	createWorld: function()
	{
	
	},

	checkKeys: function()
        {
                //left
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = -1;
                        this.mControlObject.mKeyY = 0;
                }
                //right
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = 1;
                        this.mControlObject.mKeyY = 0;
                }
                //up
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = 0;
                        this.mControlObject.mKeyY = -1;
                }
                //down
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKeyX = 0;
                        this.mControlObject.mKeyY = 1;
                }
                //left_up
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = -.5;
                        this.mControlObject.mKeyY = -.5;
                }
                //left_down
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKeyX = -.5;
                        this.mControlObject.mKeyY = .5;
                }
                //right_up
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = .5;
                        this.mControlObject.mKeyY = -.5;
                }
                //right_down
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKeyX = .5;
                        this.mControlObject.mKeyY = .5;
                }
                //all up...stop
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = 0;
                        this.mControlObject.mKeyY = 0;
                }
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
                for (i=this.mLeftBounds + 50 / 2; i <= this.mRightBounds - 50 / 2; i = i + 50)
                {       
                        this.mPositionXArray.push(i);   
                }
        
                for (i=this.mTopBounds + 50 / 2; i <= this.mBottomBounds - 50 / 2; i = i + 50)
                {       
                        this.mPositionYArray.push(i);   
                }
        },

        createShapes: function()
        {
        	//control object
                this.mControlObject = new ShapeCollidable(this,"",50,50,100,100,"","blue","","middle");
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
                for (s = 0; s < this.mShapeCollidableArray.length; s++)
                {
                        var x1 = this.mShapeCollidableArray[s].mPositionX;
                        var y1 = this.mShapeCollidableArray[s].mPositionY;
 
                        for (i = 0; i < this.mShapeCollidableArray.length; i++)
                        {
                        	if (this.mShapeCollidableArray[i].mCollisionOn == true && this.mShapeCollidableArray[s].mCollisionOn == true)
                                {
                               		if (this.mShapeCollidableArray[i] == this.mShapeCollidableArray[s])
					{
						continue;
					}
                                        var x2 = this.mShapeCollidableArray[i].mPositionX;              
                                        var y2 = this.mShapeCollidableArray[i].mPositionY;              
                
                                        var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
					var collisionDistance = this.mShapeCollidableArray[s].mCollisionDistance + this.mShapeCollidableArray[i].mCollisionDistance;
						
                                        if (distSQ < collisionDistance) 
                                        {
                                        	this.evaluateCollision(this.mShapeCollidableArray[s].mId,this.mShapeCollidableArray[i].mId);                      
                                        }
                        	}
                        }
                }
        },

        evaluateCollision: function(mId1,mId2)
        {
        
	},

        checkForScoreNeeded: function()
        {
        
	},

        //reset
        resetGame: function()
        {
        
	}
});


