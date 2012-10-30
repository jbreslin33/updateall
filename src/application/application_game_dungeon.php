var ApplicationGameDungeon = new Class(
{

Extends: ApplicationGame,

	initialize: function()
	{
       		this.parent();

		//create control object
		this.createControlObject("/images/characters/wizard.png");

        	//*****************KEY
        	var keyQuestion = new Question('Pick up key.',"key");
        	mQuiz.mQuestionArray.push(keyQuestion);

        	openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        	var key = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,keyQuestion,"/images/key/key_dungeon.gif","","key");
        	key.setVisibility(false);
        	key.mShowOnlyOnQuizComplete = true;
       	 	key.mMountable = true;
        	key.setHideOnQuestionSolved(false);
        	mGame.addToShapeArray(key);
	
        	//*****************DOOR
        	var doorQuestion = new Question('Open door with key.',"door");
        	mQuiz.mQuestionArray.push(doorQuestion);

        	var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        	var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,mGame,doorQuestion,"/images/doors/door_closed.png","","door","/images/doors/door_open.png");
        	door.mUrl = '/src/database/goto_next_level.php';
        	door.mOpenOnQuestionSolved = true;
        	mGame.addToShapeArray(door);

		//create question shapes
		this.createQuestionShapes();

		//************************CHASERS	
		for (i = 0; i < 0; i++)
		{
			var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
       			var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","chaser");
        		mGame.addToShapeArray(shape);
		}	 
	},

	createControlObject: function(image_source)
	{
		//*******************CONTROL OBJECT
        	mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),image_source,"","controlObject");
        	mGame.mControlObject.mHideOnQuestionSolved = false;
        	mGame.mControlObject.createMountPoint(0,-5,-41);

        	//set animation instance
        	mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

        	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

        	mGame.addToShapeArray(mGame.mControlObject);
        	mGame.mControlObject.showQuestionObject(false);

        	//text question mountee
        	var questionMountee = new Shape(100,50,300,300,mGame,mQuiz.getSpecificQuestion(0),"","orange","questionMountee");
        	questionMountee.setMountable(true);
        	questionMountee.setHideOnDrop(true);
        	mGame.addToShapeArray(questionMountee);
        	mGame.mControlObject.setStartingMountee(questionMountee);

        	//do the mount
        	mGame.mControlObject.mount(questionMountee,0);

        	questionMountee.setBackgroundColor("transparent");
        	questionMountee.showQuestion(true);
	},

	createQuestionShapes: function()
	{
                count = 0;
                for (i = 0; i < numberOfRows; i++)
                {
                        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                        var shape;
                        mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),"/images/treasure/gold_coin_head.png","","question"));
                        shape.createMountPoint(0,-5,-41);
                        shape.showQuestion(false);

                        //numberMount to go on top let's make it small and draw it on top
                        var questionMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(count),"","orange","questionMountee");
                        questionMountee.setMountable(true);
                        mGame.addToShapeArray(questionMountee);
                        questionMountee.showQuestion(false);

                        //do the mount
                        shape.mount(questionMountee,0);

                        questionMountee.setBackgroundColor("transparent");

                        count++;
                }
	}

	
});

