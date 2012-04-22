var ShapeCollidableDungeonCount = new Class(
{

Extends: ShapeCollidable, 

        initialize: function(container,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType)
        {
        	this.parent(container,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType);
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
			}
		}	
	
		this.parent(col);
	}

});

