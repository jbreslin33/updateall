var ApplicationGameChooser = new Class(
{

Extends: ApplicationGame,

	initialize: function()
	{
       		this.parent();

		//create doors	
		this.createDoors();
	},

	createQuestionShapes: function(image_source)
	{
	},

	createChasers: function(image_source)
	{
                for (i = 0; i < 0; i++)
                {
                        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                        var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,mGame,"",image_source,"","chaser");
                        mGame.addToShapeArray(shape);
                }

	},
	
	createDoors: function()
	{
		for (i = 0; i < numberOfRows; i++)
		{
        		var doorQuestion = new Question('Open door with key.',"door");
        		mQuiz.mQuestionArray.push(doorQuestion);
		
			x = i * 50 + 400;

        		var door = new ShapeDoor(50,50,x,350,mGame,doorQuestion,picture_closed[i],"","door",picture_open[i]);
			door.mUrl = url[0];
        		//door.mOpenOnQuestionSolved = true;
			door.setOpenDoor(true);
        		mGame.addToShapeArray(door);
		}
	},

        createHud: function()
        {
        	mHud = new Hud();
        	mHud.mScoreNeeded.setText('<font size="2"> Needed : 1 </font>');
        	mHud.mGameName.setText('<font size="2">GAME CHOOSER</font>');
        },

	createQuiz: function()
	{
                mQuiz = new Quiz(1);
                mGame.mQuiz = mQuiz;
	},

	createQuestions: function()
	{
	
	}
});
