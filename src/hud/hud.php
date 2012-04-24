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
        
		//score
		this.mScoreHud;

        },

	getGame: function()
	{
		return mGame;
	},

        update: function()
        {
                if (this.mOn)
                {
                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
                        	this.mShapeArray[i].update(this.mGame.mTimeSinceLastInterval); 
				
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
		this.mGameNameHud    = new Shape(this,"",140,50,0,0,"" + this.mGame.mName,"violet","","normal","hud");
		this.mScoreHud 	     = new Shape(this,"",140,50,0,50,"","pink","","normal","hud");
		this.mScoreNeededHud = new Shape(this,"",140,50,0,100,"","violet","","normal","hud");
		this.mFeedbackHud    = new Shape(this,"",140,50,0,150,"","pink","","normal","hud");
		this.mQuestionHud    = new Shape(this,"",140,50,0,200,"","violet","","normal","hud");

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


