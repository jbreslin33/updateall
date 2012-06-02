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

		/***************** HUD ****************/
                this.mGameNameHud    = new Shape("","","","",100,50,0,0,"" + this.mSkill,"violet","","hud");
              	this.mFeedbackHud    = new Shape("","","","",100,50,0,50,"HAV FUN!","pink","","hud");
        },

 	resetGame: function()
        {
                //reset collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
                        //set every shape to spawn position
                        this.mShapeArray[i].mPosition.mX = this.mShapeArray[i].mPositionSpawn.mX;
                        this.mShapeArray[i].mPosition.mY = this.mShapeArray[i].mPositionSpawn.mY;
                        this.mShapeArray[i].setVisibility(true);
                }

                for (i=0; i < this.mShapeArray.length; i++)
                {
                        if (this.mShapeArray[i].mCollidable == true)
                        {
                                this.mShapeArray[i].mCollisionOn = true;
                        }
                }

        },

	/*********************** PUBLIC ***************************/

	setFeedback: function(feedback)
	{
		this.mFeedbackHud.setText(feedback);
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
                        	this.mShapeArray[i].updateVelocity(this.mDeltaTime);
                        	this.mShapeArray[i].updatePosition();
                        	this.mShapeArray[i].updateAnimation();
                        	this.mShapeArray[i].updateScreen();

				//i think i should move their mPosition which does nothing. then i can do a check here

				//then i can "render" them.	
                	}

			//collision Detection
			this.checkForCollisions();
        
                	//save old positions
                	this.saveOldPositions();
			var t=setTimeout("mGame.update()",32)
                }
        },

	protectScrollBars: function(x,y)
        {
                //if off screen then hide it so we don't have scroll bars mucking up controls
                if (x + this.mWidth  + 3 > mApplication.mWindow.x ||
                        y + this.mHeight + 13 > mApplication.mWindow.y)
                {
                        //set the render position so that we leave mPosition alone.
                        this.mPositionRender.mX = 0;
                        this.mPositionRender.mY = 0;

                        if (this.getVisibility())
                        {
                                this.setVisibility(false);

                        }
                        this.mOutOfViewPort = true;
                }
                else
                {
                        if (this.mOutOfViewPort == true)
                        {
                                if (this.getVisibility() == false)
                                {
                                        this.setVisibility(true);
                                }
                        }
                }
        },


	createWall: function(width,length,color,spawnX,spawnY)
        {
                var s = new Shape(this,"","","",width,length,spawnX,spawnY,"",color,"","wall",this);
		s.mCollidable = false;
		s.mCollisionOn = false;
                this.addToShapeArray(s);
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
				if (this.mShapeArray[i].mCollidable ==  true)
				{
                                        if (this.mShapeArray[i].mCollisionOn == true && this.mShapeArray[s].mCollisionOn == true)
                                        {
                                                if (this.mShapeArray[i] == this.mShapeArray[s])
                                                {
                                                        continue;
                                                }
                                                var x2 = this.mShapeArray[i].mPosition.mX;              
                                                var y2 = this.mShapeArray[i].mPosition.mY;              
                
                                                var addend1 = x1 - x2;
						addend1 = addend1 * addend1;

                                                var addend2 = y1 - y2;
						addend2 = addend2 * addend2;

                                                var distSQ = addend1 + addend2;
						
                                                var collisionDistance = this.mShapeArray[s].mCollisionDistance + this.mShapeArray[i].mCollisionDistance;
                                                
                                                if (distSQ < collisionDistance) 
                                                {
                                                        this.evaluateCollision(this.mShapeArray[s],this.mShapeArray[i]);                      
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


