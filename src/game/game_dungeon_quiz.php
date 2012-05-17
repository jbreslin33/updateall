var GameDungeonQuiz = new Class(
{

Extends: GameDungeon,

        initialize: function(skill)
        {
                //application
                this.parent(skill);
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
				//this should just check for collision on certail block on wall for now i will hardcode
                        	if (this.mControlObject.mPosition.mX > 400 - 50 / 2 &&
                        	this.mControlObject.mPosition.mY > -300 &&
                        	this.mControlObject.mPosition.mY < -300 + 50 * 2)
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
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "wall")
		{
			if (col2.mBackgroundColor == 'white')
			{
                		if (this.mQuiz.isQuizComplete())
				{
					//this should just check for collision on certail block on wall for now i will hardcode
                        		if (this.mControlObject.mPosition.mX > 400 - 50 / 2 &&
                        		this.mControlObject.mPosition.mY > -300 &&
                        		this.mControlObject.mPosition.mY < -300 + 50 * 2)
                        		{
                                		this.mOn = false;
						this.setFeedback("YOU WIN!!!");
                                		window.location = "../database/goto_next_math_level.php"
                        		}
				}
			}
		}
 	}).protect()

});



