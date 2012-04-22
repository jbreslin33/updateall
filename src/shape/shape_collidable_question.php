var ShapeCollidableQuestion = new Class(
{

Extends: ShapeCollidable,

        initialize: function(container,src,width,height,spawnX,spawnY,isQuestion,answer,collidable,collisionOn,innerHTML,backgroundColor,onClick,drawType)
        {
               
        	this.parent(container,src,width,height,spawnX,spawnY,collidable,collisionOn,innerHTML,backgroundColor,onClick,drawType);
		//questions 
		this.mIsQuestion = isQuestion;
               
		//answers 
		this.mAnswer = answer;
              
		if (this.mAnswer == "")
		{
			//html	
			this.mInnerHTML = innerHTML; 
		}
		else
		{
			//html
			this.mInnerHTML = this.mAnswer; 
		}
        
        },
        
        update: function(delta)
        {
		this.parent(delta);
        },

	sortGameVisibility: function(x,y)
	{
        	if (this.mCollisionOn ||
                	this.mIsQuestion == 'false')
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

