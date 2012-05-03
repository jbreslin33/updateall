/**********************************************
public methods
----------------------

************************************************/

var ShapeCenter = new Class(
{

Extends: Shape,

        initialize: function(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message,game)
        {
		                
        	this.parent(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
		
		//game
		this.mGame = game;
        },

        draw: function()
        {
		//center image relative to position
                //get the offset from control object
                var xdiff = this.mPosition.mX - this.mGame.getControlObject().mPosition.mX;
                var ydiff = this.mPosition.mY - this.mGame.getControlObject().mPosition.mY;

                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);

                this.setPosition(posX,posY);
        }

});

