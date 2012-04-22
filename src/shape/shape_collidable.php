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
		if (this == this.mContainer.getGame().mControlObject)
                {
                        if (col.mInnerHTML)
                        {
                                if (this.mContainer.getGame().mQuiz.checkAnswer(col.mInnerHTML))                   
                                {
                                        col.mCollisionOn = false;
                                        col.setVisibility(false);

                                        //feedback
                                        this.mContainer.getGame().mHud.setFeedback("Correct!"); 
                                }
                                else
                                {
                                        //feedback
                                        this.mContainer.getGame().mHud.setFeedback("Wrong! Try again."); 

                                        //this deletes and then recreates everthing.
                                        this.mContainer.getGame().resetGame();
                                }
                               
                                //get a new question 
                                this.mContainer.getGame().mQuiz.newQuestion();
                                
                                //set text of control object
                                this.setText(this.mContainer.getGame().mQuiz.mCount);

                                this.mContainer.getGame().mQuiz.newAnswer();
			}
		}	

		this.mPositionX = this.mOldPositionX;
                this.mPositionY = this.mOldPositionY;
	},

/*
 if (this.mShapeArray[mId1] == this.mControlObject)
                {
                        if (this.mShapeArray[mId2].mInnerHTML)
                        {
                                if (this.mQuiz.checkAnswer(this.mShapeArray[mId2].mInnerHTML))                   
                                {
                                        this.mShapeCollidableArray[mId2].mCollisionOn = false;
                                        this.mShapeArray[mId2].setVisibility(false);

                                        //feedback
                                        this.mHud.setFeedback("Correct!"); 
                                }
                                else
                                {
                                        //feedback
                                        this.mHud.setFeedback("Wrong! Try again."); 

                                        //this deletes and then recreates everthing.
                                        this.resetGame();
                                }
                               
                                //get a new question 
                                this.mQuiz.newQuestion();
                                
                                //set text of control object
                                this.mControlObject.setText(this.mQuiz.mCount);

                                this.mQuiz.newAnswer();

*/
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

