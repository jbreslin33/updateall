var DungeonHowMany = new Class(
{

Extends: Dungeon,

        initialize: function(skill)
        {
                //application
                this.parent(skill);
		this.mResetCountMonsters = true;
        },

	update: function()
	{
		this.parent();
/*
		if (this.mQuiz)
		{
			if (this.mQuiz.isQuizComplete())
			{
		                //open the doors
                		for (i=0; i < this.mShapeArray.length; i++)
                		{
                        		if (this.mShapeArray[i].mSrc == "/images/doors/door_closed.png")
                        		{
                                		this.mShapeArray[i].setSrc("/images/doors/door_open.png");
					}
				}
                        }
                }
*/
        },

	resetGame: function()
	{
		this.parent();
/*
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
*/
		this.setCountMonsters();
	},

	setCountMonsters: function()
	{
		numberToCount = this.mQuiz.getQuestion().getAnswer();

		for (i=0; i < this.mShapeArray.length; i++)
		{	
			if (this.mShapeArray[i].mMessage == "countee")
			{
				this.mShapeArray[i].mCollisionOn = false;
				this.mShapeArray[i].setVisibility(false);
			}
		}
	
		adding = 0;	
		for (i=0; i < this.mShapeArray.length; i++)
		{	
			if (this.mShapeArray[i].mMessage == "countee")
			{
				if (adding < numberToCount)
				{
					adding++;
					this.mShapeArray[i].mCollisionOn = true;
					this.mShapeArray[i].setVisibility(true);
				}
			}
		}
	},

	evaluateCollision: (function(col1,col2)
        {
		resetCount = false;	
	
                //you ran into a question shape lets resolve it
                if (col1.mMessage == "controlObject" && col2.mMessage == "question")
                {
                        if (col1.mMountee)
                        {
                                if (col1.mMountee.mQuestion.getAnswer() == col2.mQuestion.getAnswer())
                                {
					resetCount = true;
				}
			}		
		}		
	
	        this.parent(col1,col2);
		if (resetCount)
		{
			this.setCountMonsters();			
		}
/*
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
					mApplication.log('setvis');
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
			if (col2.mSrc == "/images/doors/door_open.png")
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
*/
 	}).protect()

});



