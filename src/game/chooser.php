var Chooser = new Class(
{

Extends: GameQuiz,

	initialize: function()
	{
       		this.parent();

		this.mPortal = 0;
	},

	createQuestionShapes: function()
	{
	},

	createChasers: function()
	{
                for (i = 0; i < 0; i++)
                {
                        var openPoint = this.getOpenPoint2D(40,735,75,375,50,7);
                        var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,this,"","/images/monsters/red_monster.png","","chaser");
                        this.addToShapeArray(shape);
                }

	},
	
	createPortals: function()
	{
		for (i = 0; i < numberOfRows; i++)
		{
        		var portalQuestion = new Question('Click on me to play.',"portal");
        		this.mQuiz.mQuestionArray.push(portalQuestion);
		
			x = i * 50 + 400;

        		mPortal = new ShapePortal(50,50,x,350,this,portalQuestion,picture_closed[i],"","door",picture_open[i]);
			mPortal.mUrl = url[0];
			mPortal.setOpenPortal(true);
        		this.addToShapeArray(mPortal);
		}
	},

        createHud: function()
        {
        	mHud = new Hud();
        	mHud.mScoreNeeded.setText('<font size="2"> Needed : 1 </font>');
        	mHud.mGameName.setText('<font size="2">GAME CHOOSER</font>');
        },

	createQuestions: function()
	{
	
	}


});
