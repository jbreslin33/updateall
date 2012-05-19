var GameDungeonQuiz = new Class(
{

Extends: Game,

        initialize: function(skill)
        {
                //application
                this.parent(skill);
        },

	update: function()
	{
		this.parent();

		if (this.mQuiz)
		{
			if (this.mQuiz.isQuizComplete())
			{
		                //open the doors
                		for (i=0; i < this.mShapeArray.length; i++)
                		{
                        		if (this.mShapeArray[i].mBackgroundColor == 'green')
                        		{
                                		this.mShapeArray[i].setBackgroundColor('white');
					}
				}
                        }
                }
        },

	resetGame: function()
	{
		this.parent();

		//let's reset all quiz stuff right here.
                if (this.mQuiz)
		{ 
			this.mQuiz.reset();

			//set text of control object
			//this.mControlObject.setText(this.mQuiz.getQuestion().getQuestion());
		}
	},

	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);

		//if you get hit with a chaser then reset game or maybe lose a life 
                if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
                        //feedback
                        this.setFeedback("Try again.");

                        //this deletes and then recreates everthing.
                        this.resetGame();
                }

		//you ran into a question shape lets resolve it	
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
                                	//col1.setText(this.mQuiz.getQuestion().getQuestion());
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

		//exit room to next level when you complete quiz		
		if (col1.mMessage == "controlObject" && col2.mMessage == "wall")
		{
			if (col2.mBackgroundColor == 'white')
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
			}
		}
 	}).protect()

});



