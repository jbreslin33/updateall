var ShapeCollidable = new Class(
{

Extends: Shape, 

        initialize: function(container,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType)
        {
        	this.parent(container,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType);
                
                this.mCollisionOn = true;

	        //collisionDistance
                this.mCollisionDistance = this.mWidth * 6.5;

                //add to array
                this.mContainer.getGame().mShapeCollidableArray.push(this);

        },
        
        update: function(delta)
        {
       		this.parent(delta);
	
		if (this.mCollisionOn == true)
		{	
			this.checkForCollision();
		}
        },

	checkForCollision: function()
        {
                for (s = 0; s < this.mContainer.getGame().mShapeCollidableArray.length; s++)
                {
                        var x1 = this.mContainer.getGame().mShapeCollidableArray[s].mPositionX;
                        var y1 = this.mContainer.getGame().mShapeCollidableArray[s].mPositionY;
 
                        if (this.mContainer.getGame().mShapeCollidableArray[s].mCollisionOn == true)
                        {
                        	if (this == this.mContainer.getGame().mShapeCollidableArray[s])
                                {
                                        continue;
                                }
                                var x2 = this.mPositionX;              
                                var y2 = this.mPositionY;              
               
                                var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                                var collisionDistance = this.mContainer.getGame().mShapeCollidableArray[s].mCollisionDistance + this.mCollisionDistance;
                                                
                                if (distSQ < collisionDistance) 
                                {
                                	this.evaluateCollision(this.mContainer.getGame().mShapeCollidableArray[s]);  
                                	this.mContainer.getGame().mShapeCollidableArray[s].evaluateCollision(this);  
                                }
                	}
		}
        },

	evaluateCollision: function(col)
	{
		this.mPositionX = this.mOldPositionX;
                this.mPositionY = this.mOldPositionY;
	},

	sortGameVisibility: function(x,y)
	{
        	if (this.mCollisionOn)
                {
                	this.setPosition(x,y);
                       	this.setVisibility(true);
                }
                else
                {
                	this.setPosition(0,0);
                        this.setVisibility(false);
                }
	}

});

