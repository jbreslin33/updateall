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
                	}
                }
        },

	createHud: function()
	{
		this.mScoreHud 	     = new Shape(this,"",140,50,0,200,false,false,"",false,false,false,"","pink","","normal");
		this.mScoreNeededHud = new Shape(this,"",140,50,0,250,false,false,"",false,false,false,"","violet","","normal");
		this.mFeedbackHud    = new Shape(this,"",140,50,0,300,false,false,"",false,false,false,"","pink","","normal");

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

        //reset
        resetHud: function()
        {
	}
});


