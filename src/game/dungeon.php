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
        },

	resetGame: function()
	{
		this.parent();
	},

	quizComplete: function()
	{
        	//open the doors
               	for (i=0; i < this.mShapeArray.length; i++)
               	{
              		if (this.mShapeArray[i].mSrc == "/images/doors/door_closed.png")
                       	{
                      		this.mShapeArray[i].setSrc("/images/doors/door_open.png");
			}
		}

	},

	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
/*
		//a dropbox_question recieving a pickup from a control object 
		if (col1.mMessage == "controlObject" && col2.mMessage == "dropbox_question")
		{
			//check for correct answer
			if (col1.mMountee)
			{
				if (col1.mMountee.mQuestion.getAnswer() == col2.mQuestion.getAnswer())
				{
          				if (this.mQuiz)
                                        {
                                                this.mQuiz.correctAnswer();
                                        }      
                                        
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

			pickup = 0;	
			if (col1.mMountee.mMessage == "pickup")
			{
				pickup = col1.mMountee;

				//have controlObject unMount pickup
				col1.unMount();					
				
				//have dropbox_question mount pickup
                		//ie is showing this too high
                		if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
                		{
                        		col2.mount(pickup,-5,-41);
                		}
                		else
                		{
                        		col2.mount(pickup,-5,-58);
                		}
			}
		}	
		*/

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



