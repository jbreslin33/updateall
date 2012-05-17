var GameDungeonQuiz = new Class(
{

Extends: GameDungeon,

        initialize: function(name)
        {
                //application
                this.parent(name);
        },

	resetGame: function()
	{
		this.parent();

		//let's reset all quiz stuff right here.
                if (this.mQuiz)
		{ 
			this.mQuiz.reset();

			//set text of control object
			this.mControlObject.setText(this.mQuiz.getQuestion().getQuestion());
		}
	},

        isEndOfGame: function()
        {
       		if (this.mQuiz)
		{	
			if (this.mQuiz.isQuizComplete()) 
                	{
              			this.openTheDoors(); 
                	}
		}
        },

        checkForDoorEntered: function()
        {
		if (this.mQuiz)
		{
                	if (this.mQuiz.isQuizComplete())
                	{
                        	if (this.mControlObject.mPosition.mX > this.mRightBounds - 50 / 2 &&
                        	this.mControlObject.mPosition.mY > this.mTopBounds &&
                        	this.mControlObject.mPosition.mY < this.mTopBounds + 50 * 2)
                        	{
                                	this.mOn = false;
					this.setFeedback("YOU WIN!!!");
                                	window.location = "../database/goto_next_math_level.php"
                        	}
                	}
		}
        },
	
	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "question")
		{
			if (col1.mInnerHTML == col2.mQuestion.getQuestion())
                        {
                        	if (this.mQuiz)
				{ 
					this.mQuiz.correctAnswer();
			       	}	
				col2.mCollisionOn = false;
                                col2.setVisibility(false);

                                //feedback
                                this.setFeedback("Correct!");

                                //set text of control object
                        	if (this.mQuiz)
				{ 
                                	col1.setText(this.mQuiz.getQuestion().getQuestion());
				}
                        }
                        else
                        {
                                //feedback
                                this.setFeedback("Try again.");

                                //this deletes and then recreates everthing.
                                this.resetGame();
                        }
                }

 	}).protect()

});



