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

		/********* SHAPES *******************/ 
		//control object
                this.mControlObject;
                
		//shape Array
                this.mShapeArray = new Array();

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
                this.mGameNameHud    = new Shape("",140,50,0,0,"" + this.getName(),"violet","","hud");
              	this.mFeedbackHud    = new Shape("",140,50,0,50,"HAV FUN!","pink","","hud");
        },
	
	/*********************** PUBLIC ***************************/

	setFeedback: function(feedback)
	{
		this.mFeedbackHud.setText(feedback);
	},

	getName: function()
	{
		return this.mName;
	},

	getControlObject: function()
	{
		return this.mControlObject;
	},

	/**************** ADD METHODS *************/
	addToShapeArray: function(shape)
	{
		this.mShapeArray.push(shape);
	},
	
	addToShapeCollidableArray: function(shape)
	{
		this.mShapeCollidableArray.push(shape);
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

			//collision Detection
			this.checkForCollisions();

                	//check for end game
                	this.checkForScoreNeeded();
        
                	//save old positions
                	this.saveOldPositions();
			var t=setTimeout("mGame.update()",20)
                }
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
                        if (this.mPositionXArray[this.mProposedX] == this.mShapeArray[r].mPosition.mX && this.mPositionYArray[this.mProposedY] == this.mShapeArray[r].mPosition.mY)
                        {
                                r = 0;
                                this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
                                this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
                        }
                        if (r > 0)
                        {       
                                if (
                                Math.abs(this.mPositionXArray[this.mProposedX] - this.mShapeArray[r-1].mPosition.mX) > 350 
                                        ||
                                Math.abs(this.mPositionYArray[this.mProposedY] - this.mShapeArray[r-1].mPosition.mY) > 350                        
                                ) 
                                {
                                        r = 0;
                                        this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
                                        this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
                                }
                                if (
                                Math.abs(this.mPositionXArray[this.mProposedX] - this.mControlObject.mPosition.mX) < 100 
                                        && 
                                Math.abs(this.mPositionYArray[this.mProposedY] - this.mControlObject.mPosition.mY) < 100                  
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
                        this.mControlObject.mKey.mX = -1;
                        this.mControlObject.mKey.mY = 0;
                }
                //right
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 1;
                        this.mControlObject.mKey.mY = 0;
                }
                //up
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = -1;
                }
                //down
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = 1;
                }
                //left_up
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = -.5;
                        this.mControlObject.mKey.mY = -.5;
                }
                //left_down
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = -.5;
                        this.mControlObject.mKey.mY = .5;
                }
                //right_up
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = .5;
                        this.mControlObject.mKey.mY = -.5;
                }
                //right_down
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = .5;
                        this.mControlObject.mKey.mY = .5;
                }
                //all up...stop
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = 0;
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
                        this.mShapeArray[i].mPosition.mX = this.mShapeArray[i].mPosition.mX;
                        this.mShapeArray[i].mPosition.mY = this.mShapeArray[i].mPosition.mY;
                }
        }).protect(),

        checkForScoreNeeded: (function()
        {
        
	}).protect(),

        //reset
        resetGame: (function()
        {
        
	}).protect(),

	checkForCollisions: (function()
        {
                for (s = 0; s < this.mShapeArray.length; s++)
                {
			if (this.mShapeArray[s].mCollidable ==  true)
			{
                        	var x1 = this.mShapeArray[s].mPosition.mX;
                        	var y1 = this.mShapeArray[s].mPosition.mY;
 
                        	for (i = 0; i < this.mShapeArray.length; i++)
                        	{
                                        if (this.mShapeArray[i].mCollisionOn == true && this.mShapeArray[s].mCollisionOn == true)
                                        {
                                                if (this.mShapeArray[i] == this.mShapeArray[s])
                                                {
                                                        continue;
                                                }
                                                var x2 = this.mShapeArray[i].mPosition.mX;              
                                                var y2 = this.mShapeArray[i].mPosition.mY;              
                
                                                var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                                                var collisionDistance = this.mShapeArray[s].mCollisionDistance + this.mShapeArray[i].mCollisionDistance;
                                                
                                                if (distSQ < collisionDistance) 
                                                {
                                                        this.evaluateCollision(this.mShapeArray[s],this.mShapeArray[i]);                      
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

	}).protect()

});


