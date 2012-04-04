var ShapeGui = new Class({
    Extends: Shape,
        
        initialize: function (game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
        {
                this.parent(game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick);
        },

        draw: function()
        {
                //mGame.mApplication.log('ShapeGui:Draw');      
                this.parent();
                
                this.mWidth = mGame.mWindow.x / 3;
                this.mHeight = mGame.mWindow.y / 3;

                if (this.mInnerHTML == "DOWN")
                {
                        this.mHeight = this.mHeight - 13;
                }
                                
                this.mMesh.style.width=this.mWidth+'px'; 
                this.mMesh.style.height=this.mHeight+'px'; 
                                        
                //now get the position
                if (this.mOnClick == mApplication.moveLeft)
                {
                        this.mPositionX = 0; 
                        this.mPositionY = mGame.mWindow.y / 2 - this.mShapeCenterY; 
                }
                
                if (this.mOnClick == mApplication.moveRight)
                {
                        var tempx = mGame.mWindow.x / 6;
                        tempx = mGame.mWindow.x - tempx;
                                
                        this.mPositionX = tempx - this.mShapeCenterX; 
                        this.mPositionY = mGame.mWindow.y / 2 - this.mShapeCenterY; 
                }
                
                if (this.mOnClick == mApplication.moveUp)
                {
                        this.mPositionX = mGame.mWindow.x / 2 - this.mShapeCenterX; 
                        this.mPositionY = 0; 
                }
                
                if (this.mOnClick == mApplication.moveDown)
                {
                        this.mPositionX = mGame.mWindow.x / 2 - this.mShapeCenterX; 
                        
                        var tempy = mGame.mWindow.y / 6;
                        tempy = mGame.mWindow.y - tempy;
                        this.mPositionY = tempy - this.mShapeCenterY - 13; 
                }
                
                if (this.mOnClick == mApplication.moveStop)
                {
                        this.mPositionX = mGame.mWindow.x / 2 - this.mShapeCenterX; 
                        this.mPositionY = mGame.mWindow.y / 2 - this.mShapeCenterY; 
                }

                this.mDiv.style.left = this.mPositionX+'px';
                this.mDiv.style.top  = this.mPositionY+'px';
        }
});

