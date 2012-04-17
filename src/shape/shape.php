var Shape = new Class(
{
        initialize: function(game,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,innerHTML,backgroundColor,onClick,drawType)
        {
                
                //game
                this.mGame = game;      
		
		//id 
		this.mId = this.mGame.mIdCount;
		
		//ai
		this.mAI = ai;  
                this.mAiCounter = 0;
                this.mAiCounterDelay = 10;
		
		//src 
		this.mSrc = src;
               
		//size 
		this.mWidth = width;
                this.mHeight = height;
                
		//position
		this.mPositionX = spawnX;
                this.mPositionY = spawnY;
                this.mOldPositionX = spawnX;
                this.mOldPositionY = spawnY;
                this.mSpawnPositionX = spawnX;
                this.mSpawnPositionY = spawnY;
               
		//velocity 
		this.mVelocityX = 0;
                this.mVelocityY = 0;
                
		//keys
		this.mKeyX = 0;
                this.mKeyY = 0;
                
		//collision
		this.mCollidable = collidable;
                this.mCollisionOn = collisionOn;
               
		//questions 
		this.mIsQuestion = isQuestion;
               
		//answers 
		this.mAnswer = answer;
              
		if (this.mAnswer == "")
		{
			//html	
			this.mInnerHTML = innerHTML; 
		}
		else
		{
			//html
			this.mInnerHTML = this.mAnswer; 
		}
 
                
		//background
		this.mBackgroundColor = backgroundColor;
                
		//onclick	
		this.mOnClick = onClick;
              
		//drawType
		this.mDrawType = drawType;
 
		//control object 
                if (isControlObject)
                {
                        this.mGame.mControlObject = this;
                }
        
                //add to array
                this.mGame.mShapeArray.push(this);

                //create the movable div that will be used to move image around.        
		this.mDiv = new Div(this);

                this.mMesh;
        
                //create clientImage
                if (this.mSrc)
                {
                        //image to attach to our div "vessel"
                        this.mMesh  = document.createElement("IMG");
                        this.mMesh.id = 'image' + this.mId;
                        this.mMesh.alt = 'image' + this.mId;
                        this.mMesh.title = 'image' + this.mId;   
                        this.mMesh.src  = this.mSrc;
                        this.mMesh.style.width = this.mWidth+'px'; 
                        this.mMesh.style.height = this.mHeight+'px'; 
                }
                
		if (this.mSrc == "")//create paragraph
                {
                	this.mMesh = document.createElement("p");
                        this.mMesh.innerHTML = this.mInnerHTML;
                }

                //back to div   
                this.mDiv.mDiv.appendChild(this.mMesh);
		this.mGame.mIdCount++;
        
        },
        
        update: function()
        {
                //run ai                
                if (this.mAiCounter > this.mAiCounterDelay)
                {       
                        this.ai();
                        this.mAiCounter = 0;
                }
                this.mAiCounter++;
                
                //update Velocity
                this.mVelocityX = this.mKeyX * this.mGame.mTimeSinceLastInterval * this.mGame.mSpeed;
                this.mVelocityY = this.mKeyY * this.mGame.mTimeSinceLastInterval * this.mGame.mSpeed;

                //update position
                this.mPositionX += this.mVelocityX;
                this.mPositionY += this.mVelocityY;
                
                this.draw();
        },

	setPosition: function(x,y)
	{
		this.mDiv.mDiv.style.left = x+'px';
		this.mDiv.mDiv.style.top = y+'px';
	},

	setVisibility: function(b)
	{
		if (b)
		{
			this.mDiv.mDiv.style.visibility = 'visible';
		}
		else
		{
			this.mDiv.mDiv.style.visibility = 'hidden';
		}
	},		

	setText: function(t)
	{
        	this.mInnerHTML = t;	
		if (this.mSrc == "")
		{
			this.mMesh.innerHTML = this.mInnerHTML;
		}
	},

	setBackgroundColor: function(c)
	{
		this.mBackgroundColor = c;
		this.mDiv.mDiv.style.backgroundColor = c;
	},

        ai: function()
        {
                if (this.mAI == true)
                {
                        var direction = Math.floor(Math.random()*9)     
                        if (direction == 0) //left
                        {
                                this.mKeyX = -1;
                                this.mKeyY = 0;
                        }
                        if (direction == 1) //right
                        {
                                this.mKeyX = 1;
                                this.mKeyY = 0;
                        }
                        if (direction == 2) //up
                        {
                                this.mKeyX = 0;
                                this.mKeyY = -1;
                        }
                        if (direction == 3) //down
                        {
                                this.mKeyX = 0;
                                this.mKeyY = 1;
                        }
                        if (direction == 4) //leftup
                        {
                                this.mKeyX = -.5;
                                this.mKeyY = -.5;
                        }
                        if (direction == 5) //leftdown
                        {
                                this.mKeyX = -.5;
                                this.mKeyY = .5;
                        }
                        if (direction == 6) //rightup
                        {
                                this.mKeyX = .5;
                                this.mKeyY = -.5;
                        }
                        if (direction == 7) //rightdown
                        {
                                this.mKeyX = .5;
                                this.mKeyY = .5;
                        }
                        if (direction == 8) //stop
                        {
                                this.mKeyX = 0;
                                this.mKeyY = 0;
                        }
                } 
        },

        draw: function()
        {
       		if (this.mDrawType == 'relative')
		{
			this.drawRelative();
		} 
		if (this.mDrawType == 'middle')
		{
			this.drawCenter();
		}
		if (this.mDrawType == 'normal')
		{
			this.drawNormal();
		}
	},

	drawNormal: function()
	{
                //center image relative to position
                var posX = this.mPositionX - (this.mWidth / 2);
                var posY = this.mPositionY - (this.mHeight / 2);
	
		this.protectScrollBars(posX,posY);
	},

        drawRelative: function()
        {
                //get the offset from control object
                var xdiff = this.mPositionX - mGame.mControlObject.mPositionX;
                var ydiff = this.mPositionY - mGame.mControlObject.mPositionY;

                //center image relative to position
                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);
	
		this.sortGameVisibility(posX,posY);
		this.protectScrollBars(posX,posY);
        },

        drawCenter: function()
        {
                //center image relative to position
                //get the offset from control object
                var xdiff = this.mPositionX - mGame.mControlObject.mPositionX;
                var ydiff = this.mPositionY - mGame.mControlObject.mPositionY;

                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);

                this.setPosition(posX,posY);
        },

	sortGameVisibility: function(x,y)
	{
        	if (this.mCollisionOn ||
                	this.mIsQuestion == 'false')
                {
                	this.setPosition(x,y);
                       	this.setVisibility(true);
                }
                else
                {
                	this.setPosition(0,0);
                        this.setVisibility(false);
                }
	},

	protectScrollBars: function(x,y)
	{
                //if off screen then hide it so we don't have scroll bars mucking up controls
                if (x + this.mWidth  + 3 > mApplication.mWindow.x ||
                        y + this.mHeight + 13 > mApplication.mWindow.y)
                {
                        this.setPosition(0,0);
                        this.setVisibility(false);
                }
	}
});

