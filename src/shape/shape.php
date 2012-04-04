var Shape = new Class(
{
        initialize: function (game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
        {
                //replace this.....!!!!!!!!!!!!!!!!     
                this.mPageCenterX = 0;
                this.mPageCenterY = 0;
                
                this.mShapeCenterX = 0;
                this.mShapeCenterY = 0;

                //ai
                this.mAiCounter = 0;
                this.mAiCounterDelay = 10;
                
                //
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
                //run ai                
                if (this.mAiCounter > this.mAiCounterDelay)
                {       
                        this.ai();
                        this.mAiCounter = 0;
                }
                this.mAiCounter++;
                
                //update Velocity
                this.mVelocityX = this.mKeyX * this.mGame.mApplication.mTimeSinceLastInterval * this.mGame.mSpeed;
                this.mVelocityY = this.mKeyY * this.mGame.mApplication.mTimeSinceLastInterval * this.mGame.mSpeed;

                //update position
                this.mPositionX += this.mVelocityX;
                this.mPositionY += this.mVelocityY;
                
                this.draw();
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
        //      mGame.mApplication.log('Shape:Draw');   
                //get the center of the page xy
                this.mPageCenterX = mGame.mWindow.x / 2;
                this.mPageCenterY = mGame.mWindow.y / 2;
      
                //get the center xy of the image
                this.mShapeCenterX = mGame.mShapeArray[i].mWidth / 2;     
                this.mShapeCenterY = mGame.mShapeArray[i].mHeight / 2;     
        }
});

