var Dungeon = new Class(
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
                        		if (this.mShapeArray[i].mSrc == "/images/doors/door_closed.png")
                        		{
                                		this.mShapeArray[i].setSrc("/images/doors/door_open.png");
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

		//control object pickup an item
		if (col1.mMessage == "controlObject" && col2.mMessage == "pickup")
		{
			if (col1.mMountee.mMessage == "pickup")
			{
				col1.unMount();				
			}

			//do the mount
                	//ie is showing this too high
                	if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
                	{
                        	col1.mount(col2,-5,-41);
                	}
                	else
                	{
                        	col1.mount(col2,-5,-58);
                	}
		}

		//a picker picking up an item
		if (col1.mMessage == "controlObject" && col2.mMessage == "dropbox")
		{
			if (col1.mMountee.mMessage == "pickup")
			{
				//have drop box mount pickup
                		//ie is showing this too high
                		if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
                		{
                        		col2.mount(col1.mMountee,-5,-41);
                		}
                		else
                		{
                        		col2.mount(col1.mMountee,-5,-58);
                		}
				//have controlObject unMount pickup
				col1.unMount();					

					
				
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
 	}).protect()

});



