var ShapeControlObject = new Class({
    Extends: Shape,
        
        initialize: function (game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
        {
                this.parent(game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick);
        },

        draw: function()
        {
                this.parent();
                //center image relative to position
                //get the offset from control object
                var xdiff = this.mPositionX - mGame.mControlObject.mPositionX;  
                var ydiff = this.mPositionY - mGame.mControlObject.mPositionY;  

		var posX = xdiff + (this.mGame.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (this.mGame.mWindow.y / 2) - (this.mHeight / 2);    
                
                this.mDiv.mDiv.style.left = posX+'px';
                this.mDiv.mDiv.style.top  = posY+'px';
        }
});


