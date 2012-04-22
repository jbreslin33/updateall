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

