var ApplicationGame = new Class(
{

Extends: Application,

        initialize: function()
        {
                this.parent();

		//create bounds
		this.createBounds(60,735,380,35);

		//create hud
		this.createHud();

		//create game
		this.createGame("Game");

		//create quiz
		this.createQuiz();

		//create questions
		this.createQuestions();

                //create control object
                this.createControlObject("/images/characters/wizard.png");
        },

	createBounds: function(north,east,south,west)
	{
        	mBounds = new Bounds(north,east,south,west);
	},

	createHud: function()
	{
        	mHud = new Hud();
        	mHud.mScoreNeeded.setText('<font size="2"> Needed : ' + scoreNeeded + '</font>');
        	mHud.mGameName.setText('<font size="2">DUNGEON</font>');
	},

	createGame: function()
	{
        	mGame = new Game("Game");
	},

	createQuiz: function()
	{
        	mQuiz = new Quiz(scoreNeeded);
        	mGame.mQuiz = mQuiz;
	},

	createQuestions: function()
	{
        	for (i = 0; i < scoreNeeded; i++)
        	{
                	var question = new Question(questions[i],answers[i]);
                	mQuiz.mQuestionArray.push(question);
        	}
	},

        createControlObject: function(image_source)
        {
                //*******************CONTROL OBJECT
                mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),image_source,"","controlObject");

                //set animation instance
                mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);
                mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');
                mGame.addToShapeArray(mGame.mControlObject);
                
		mGame.mControlObject.mHideOnQuestionSolved = false;
                mGame.mControlObject.createMountPoint(0,-5,-41);
	},

        createQuestionShapes: function()
        {
        
	}
});

