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
                var posX = xdiff + (this.mGame.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (this.mGame.mWindow.y / 2) - (this.mHeight / 2);    
                        
                //if off screen then hide it so we don't have scroll bars mucking up controls 
                if (posX + this.mWidth  + 3 > mGame.mWindow.x ||
                        posY + this.mHeight + 13 > mGame.mWindow.y)
                {
			this.setPosition(0,0);
                        this.mDiv.mDiv.style.visibility = 'hidden';  
                }
                else //within dimensions..and still collidable(meaning a number that has been answered) or not a question at all
                {
                        if (this.mCollisionOn || 
                            this.mIsQuestion == 'false')
                        {       
				this.setPosition(posX,posY);
                                this.mDiv.mDiv.style.visibility = 'visible'; 
                        }
                        else
                        {
				this.setPosition(0,0);
                                this.mDiv.mDiv.style.visibility = 'hidden';  
                        }
                }
        }
});


