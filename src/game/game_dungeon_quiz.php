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

			//set the control objects question object
			this.mControlObject.setQuestion(this.mQuiz.getQuestion());
			if (this.mControlObject.mMountee)
			{	
				this.mControlObject.mMountee.setQuestion(this.mQuiz.getQuestion());
			}
		}
	},

	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);

		//if you get hit with a chaser then reset game or maybe lose a life 
                if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
                        //this deletes and then recreates everthing.
                        this.resetGame();
                }

		//you ran into a question shape lets resolve it	
		if (col1.mMessage == "controlObject" && col2.mMessage == "question")
		{
			if (col1.mMountee)
			{
				if (col1.mMountee.mQuestion.getAnswer() == col2.mQuestion.getAnswer())
                        	{
                        		if (this.mQuiz)
					{ 
						this.mQuiz.correctAnswer();
			       		}	
					col2.mCollisionOn = false;
                                	col2.setVisibility(false);

                                	//set text of control object
                        		if (this.mQuiz)
					{ 
						//set the control objects question object
						col1.setQuestion(this.mQuiz.getQuestion());
						if (col1.mMountee)
						{
							col1.mMountee.setQuestion(this.mQuiz.getQuestion());
						}
					}
                        	}
                        	else
                        	{
                                	//this deletes and then recreates everthing.
                                	this.resetGame();
                        	}
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
                                		this.mOn = false;
                                		window.location = col2.getQuestion().getAnswer(); 
                        		}
				}
			}
		}
 	}).protect()

});



