var ShapeControlObject = new Class({
    Extends: Shape,
        
        initialize: function (game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick)
        {
                this.parent(game,id,src,width,height,spawnX,spawnY,isControlObject,isQuestion,answer,collidable,collisionOn,ai,gui,innerHTML,backgroundColor,onClick);
        },

        draw: function()
        {
                this.parent();
                //alert('controlObject');       
                //center image relative to position
                //get the offset from control object
                var xdiff = this.mPositionX - mGame.mControlObject.mPositionX;  
                var ydiff = this.mPositionY - mGame.mControlObject.mPositionY;  
                
                var posX = xdiff + this.mPageCenterX - this.mShapeCenterX;
                var posY = ydiff + this.mPageCenterY - this.mShapeCenterY;    
                
                this.mDiv.style.left = posX+'px';
                this.mDiv.style.top  = posY+'px';
        }
});


