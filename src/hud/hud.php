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
                	}
                }
        },

	createHud: function()
	{
		this.mScoreHud = new Shape(this,"",50,50,300,300,false,false,"",false,false,false,"Score:0","green","","normal");
	},	

	setScore: function()
	{
		this.mScoreHud.setText("Score:" + mGame.mQuiz.getScore());
	},

        //reset
        resetHud: function()
        {
	}
});


