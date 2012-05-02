var ShapeQuizee = new Class(
{

Extends: ShapeCollidable, 

        initialize: function(game,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message)
        {
        	this.parent(game,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message);
        },
        
	evaluateCollision: function(col)
	{
        	if (col.mMessage == "question")
                {
                	if (this.getGame().mQuiz.submitAnswer(col.mInnerHTML))                   
                        {
                        	col.mCollisionOn = false;
                                col.setVisibility(false);

                                //feedback
                                this.getGame().setFeedback("Correct!"); 
                        
				//get a new question 
                        	this.getGame().mQuiz.newQuestion();
                                
                        	//set text of control object
                        	this.setText(this.getGame().mQuiz.mCount);
                        }
                        else
                        {
                        	//feedback
                                this.getGame().setFeedback("Wrong! Try again."); 

                                //this deletes and then recreates everthing.
                                this.getGame().resetGame();
                        }
		}
	
		if (col.mMessage == "chaser")
		{
                       	//feedback
                        this.getGame().setFeedback("Wrong! Try again."); 

                        //this deletes and then recreates everthing.
                        this.getGame().resetGame();
		}

		this.parent(col);
	}

});

