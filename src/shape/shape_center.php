/**********************************************
public methods
----------------------

************************************************/

var ShapeCenter = new Class(
{

Extends: Shape,

        initialize: function(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message,game)
        {
		                
        	this.parent(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message);
		
		//game
		this.mGame = game;
        },

        draw: function()
        {
		//center image relative to position
                //get the offset from control object
                var xdiff = this.mPositionX - this.mGame.getControlObject().mPositionX;
                var ydiff = this.mPositionY - this.mGame.getControlObject().mPositionY;

                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);

                this.setPosition(posX,posY);
        }

});

