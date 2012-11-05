var ApplicationGameDungeonCountStandardOrder = new Class(
{

Extends: ApplicationGameDungeon,

	initialize: function()
	{
       		this.parent();

		//create monsters to count
		this.createTreasure();
	},

	createTreasure: function()
	{
 		//TREASURE CHESTS TO COUNT
        	for (i = 0; i < scoreNeeded; i++)
        	{
                	var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                	var shape = new ShapeDropBoxCount(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(0),"/images/treasure/chest.png","","dropbox_question");
                	shape.createMountPoint(0,-5,-41);
                	shape.setHideOnQuestionSolved(false);
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
        },

        createQuestionShapes: function(image_source)
        {
                count = 0;
                for (i = 0; i < numberOfRows; i++)
                {
                        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                        var shape;
                        mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),image_source,"","question"));
                        shape.createMountPoint(0,-5,-41);
                        shape.showQuestion(false);

			shape.mMountable = true;
			shape.setHideOnQuestionSolved(false);

                        //numberMount to go on top let's make it small and draw it on top
                        var questionMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(count),"","orange","questionMountee");
                        questionMountee.setMountable(true);
                        mGame.addToShapeArray(questionMountee);
                        questionMountee.showQuestion(false);

                        //do the mount
                        shape.mount(questionMountee,0);

                        questionMountee.setBackgroundColor("transparent");

			//make it so they are never evaluated on collision but can still be picked up
			shape.setEvaluateQuestions(false);

                        count++;
                }
        }

});

