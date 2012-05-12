/**********************************************
public methods
----------------------

************************************************/

var ShapeRelativeRandom = new Class(
{

Extends: ShapeRelative,

        initialize: function(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message,game)
        {
        	this.parent(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
		
		//game
		this.mGame = game;

		openSpace = false
		while(openSpace == false)
		{ 
			//let's get a random open space...
			//get the size of the playing field
			var xSize = this.mGame.mRightBounds - this.mGame.mLeftBounds;
                	var ySize = this.mGame.mBottomBounds - this.mGame.mTopBounds;
               
                	//get point that would fall in the size range from above 
                	var point2D = new Point2D( Math.floor( Math.random()*xSize) , Math.floor(Math.random()*ySize));

                	//now add the left and top bounds so that it is on the games actual field       
                	point2D.mX += this.mGame.mLeftBounds; 
                	point2D.mY += this.mGame.mTopBounds;

			openSpace = this.checkForOpenSpace();
		}
        },

        draw: function()
        {
                //get the offset from control object
                var xdiff = this.mPosition.mX - this.mGame.getControlObject().mPosition.mX;
                var ydiff = this.mPosition.mY - this.mGame.getControlObject().mPosition.mY;

                //center image relative to position
                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);
	
		this.sortGameVisibility(posX,posY);
		this.protectScrollBars(posX,posY);
        },

	checkForOpenSpace: (function()
        {
                for (s = 0; s < this.mGame.mShapeArray.length; s++)
                {
                        if (this.mGame.mShapeArray[s].mCollidable ==  true)
                        {
                                var x1 = this.mGame.mShapeArray[s].mPosition.mX;
                                var y1 = this.mGame.mShapeArray[s].mPosition.mY;
 
                                if (this.mGame.mShapeArray[s] == this)
                                {
                                	continue;
                                }
                                
				var x2 = this.mPosition.mX;              
                                var y2 = this.mPosition.mY;              
                
                                var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                                var collisionDistance = this.mGame.mShapeArray[s].mCollisionDistance + this.mCollisionDistance;
                                                
                                if (distSQ < collisionDistance) 
                                {
                               		return false;                 
				}
                        }
                }
		
		return true;
        
	}).protect()

});

