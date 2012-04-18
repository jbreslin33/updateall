var Hud = new Class(
{

        initialize: function(game)
        {
		//game
		this.mGame = game;

                //shape Array
                this.mShapeArray = new Array();

	        //On_Off
                this.mOn = true;
        
                // id counter
                this.mIdCount = 0;

		//score
		this.mScoreHud;

        },

        update: function()
        {
                if (this.mOn)
                {
                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
                        	this.mShapeArray[i].update();
				
				//set score	
				this.setScore();

				//set score needed...this may only need be done once so it might really belong somewhere else but for now this will suffice
				this.setScoreNeeded();
				
				this.setQuestion();
                	}
                }
        },

	createHud: function()
	{
		this.mGameNameHud    = new Shape(this,"",140,50,0,0,false,false,"",false,false,false,"" + this.mGame.mName,"violet","","normal");
		this.mScoreHud 	     = new Shape(this,"",140,50,0,50,false,false,"",false,false,false,"","pink","","normal");
		this.mScoreNeededHud = new Shape(this,"",140,50,0,100,false,false,"",false,false,false,"","violet","","normal");
		this.mFeedbackHud    = new Shape(this,"",140,50,0,150,false,false,"",false,false,false,"","pink","","normal");
		this.mQuestionHud    = new Shape(this,"",140,50,0,200,false,false,"",false,false,false,"","violet","","normal");

	},	

	setScore: function()
	{
		this.mScoreHud.setText("Score:" + mGame.mQuiz.getScore());
	},

	setScoreNeeded: function()
	{
		this.mScoreNeededHud.setText("Score Needed:" + mGame.mQuiz.getScoreNeeded());
	},
	
	setFeedback: function(feedback)
	{
		this.mFeedbackHud.setText(feedback);
	},

	//question
	setQuestion: function()
	{
		this.mQuestionHud.setText("Question:" + mGame.mQuiz.getQuestion());
	},	
	
        //reset
        resetHud: function()
        {
	}
});


