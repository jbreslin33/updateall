var ApplicationGameChooser = new Class(
{

Extends: ApplicationGame,

	initialize: function()
	{
       		this.parent();

		//create control object
		this.createControlObject("/images/characters/wizard.png");

		//create key
		//this.createKey("/images/key/key_dungeon.gif");
	
		//create door	
//		var numberOfRows = 1;
//		for (i = 1; i < numberOfRows + 1; i++)
//		{ 
			this.createDoor("/images/doors/door_closed.png","/images/doors/door_open.png");
//		}
	},

	createControlObject: function(image_source)
	{
		//*******************CONTROL OBJECT
        	mGame.mControlObject = new Player(50,50,400,300,mGame,'',image_source,"","controlObject");

        	//set animation instance
        	mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

        	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

        	mGame.addToShapeArray(mGame.mControlObject);
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

	createDoor: function(image_source_closed,image_source_open)
	{
        	var doorQuestion = new Question('Open door with key.',"door");
        	mQuiz.mQuestionArray.push(doorQuestion);

        	var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        	var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,mGame,doorQuestion,image_source_closed,"","door",image_source_open);
        	//door.mUrl = '/src/database/goto_next_level.php';
		//door.mUrl = url[i-1];
		door.mUrl = url[0];
        	door.mOpenOnQuestionSolved = true;
        	mGame.addToShapeArray(door);

		//create question shapes
		this.createQuestionShapes("/images/treasure/gold_coin_head.png");

		//create chasers
		this.createChasers("/images/monster/red_monster.png");
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
