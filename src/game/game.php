/******************************************
public methods
-----------------

void setFeedback(feedback);
deltaTime getDeltaTime();
controlObject getControlObject();

//get methods

***************************************/

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
                this.mDeltaTime = 0;

		/********************** QUIZ **************/
                this.mQuiz;
               	
		/********* SHAPES *******************/ 
		
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
		
		/***************** HUD ****************/
                this.mGameNameHud    = new Shape(this,"",140,50,0,0,"" + this.getName(),"violet","","normal","hud");
              	this.mFeedbackHud    = new Shape(this,"",140,50,0,50,"HAV FUN!","pink","","normal","hud");
        },
	
	/*********************** PUBLIC ***************************/

	setFeedback: function(feedback)
	{
		this.mFeedbackHud.setText(feedback);
	},

	getGame: function()
	{
		return this;
	},

	getName: function()
	{
		return this.mName;
	},

	getDeltaTime: function()
	{
		return this.mDeltaTime;
	},

	getControlObject: function()
	{
		return this.mControlObject;
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
                	}

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
	
	/****************************** PROTECTED ***************************************/

	checkKeys: (function()
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
        }).protect(),

        fillSpawnPositionArrays: (function()
        {
                for (i=this.mLeftBounds + 50 / 2; i <= this.mRightBounds - 50 / 2; i = i + 50)
                {       
                        this.mPositionXArray.push(i);   
                }
        
                for (i=this.mTopBounds + 50 / 2; i <= this.mBottomBounds - 50 / 2; i = i + 50)
                {       
                        this.mPositionYArray.push(i);   
                }
        }).protect(),

        createShapes: (function()
        {
        	//control object
                this.mControlObject = new ShapeCollidable(this,"",50,50,100,100,"","blue","","middle","controlObject");
        }).protect(),

        
        saveOldPositions: (function()
        {
                //save old positions
                for (i = 0; i < this.mShapeArray.length; i++)
                {
                        //record old position to use for collisions or whatever you fancy
                        this.mShapeArray[i].mOldPositionX = this.mShapeArray[i].mPositionX;
                        this.mShapeArray[i].mOldPositionY = this.mShapeArray[i].mPositionY;
                }
        }).protect(),

        checkForScoreNeeded: (function()
        {
        
	}).protect(),

        //reset
        resetGame: (function()
        {
        
	}).protect()
});


