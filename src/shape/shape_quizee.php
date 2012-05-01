var ShapeQuizee = new Class(
{

Extends: ShapeCollidable, 

        initialize: function(game,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message)
        {
        	this.parent(game,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message);
        },
        
	evaluateCollision: function(col)
	{
		if (this == this.getGame().mControlObject)
                {
                        if (col.mMessage == "question" || col.mMessage == "chaser")
                        {
                                if (this.getGame().mQuiz.submitAnswer(col.mInnerHTML))                   
                                {
                                        col.mCollisionOn = false;
                                        col.setVisibility(false);

                                        //feedback
                                        this.getGame().setFeedback("Correct!"); 
                                }
                                else
                                {
                                        //feedback
                                        this.getGame().setFeedback("Wrong! Try again."); 

                                        //this deletes and then recreates everthing.
                                        this.getGame().resetGame();
                                }
                               
                                //get a new question 
                                this.getGame().mQuiz.newQuestion();
                                
                                //set text of control object
                                this.setText(this.getGame().mQuiz.mCount);
			}
		}	
	
		this.parent(col);
	}

});

