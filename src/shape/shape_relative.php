var ShapeRelative = new Class({
    Extends: Shape,
        
        initialize: function (game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
        {
                this.parent(game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick);
        },

        draw: function()
        {
                //mGame.mApplication.log('ShapeRelative:Draw'); 
                this.parent();

                //get the offset from control object
                var xdiff = this.mPositionX - mGame.mControlObject.mPositionX;  
                var ydiff = this.mPositionY - mGame.mControlObject.mPositionY;  

                //center image relative to position
                var posX = xdiff + this.mPageCenterX - this.mShapeCenterX;
                var posY = ydiff + this.mPageCenterY - this.mShapeCenterY;    
                        
                //if off screen then hide it so we don't have scroll bars mucking up controls 
                if (posX + this.mWidth  + 3 > mGame.mWindow.x ||
                        posY + this.mHeight + 13 > mGame.mWindow.y)
                {
                        this.mDiv.style.left = 0+'px';
                        this.mDiv.style.top  = 0+'px';
                        this.mDiv.style.visibility = 'hidden';  
                }
                else //within dimensions..and still collidable(meaning a number that has been answered) or not a question at all
                {
                        if (this.mCollisionOn || 
                            this.mIsQuestion == 'false')
                        {       
                                this.mDiv.style.left = posX+'px';
                                this.mDiv.style.top  = posY+'px';
                                this.mDiv.style.visibility = 'visible'; 
                        }
                        else
                        {
                                this.mDiv.style.left = 0+'px';
                                this.mDiv.style.top  = 0+'px';
                                this.mDiv.style.visibility = 'hidden';  
                        }
                }
        }
});


