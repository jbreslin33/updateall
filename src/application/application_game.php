var ApplicationGame = new Class(
{

Extends: Game,

        initialize: function()
        {
                this.parent();

		//create bounds
		this.createBounds(60,735,380,35);

		//create hud
		this.createHud();

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

	createQuiz: function()
	{
        	mQuiz = new Quiz(scoreNeeded);
        	this.mQuiz = mQuiz;
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
                this.mControlObject = new Player(50,50,400,300,this,mQuiz.getSpecificQuestion(0),image_source,"","controlObject");

                //set animation instance
                this.mControlObject.mAnimation = new AnimationAdvanced(this.mControlObject);
                this.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');
                this.addToShapeArray(this.mControlObject);
                
		this.mControlObject.mHideOnQuestionSolved = false;
                this.mControlObject.createMountPoint(0,-5,-41);
	},

        createQuestionShapes: function()
        {
        
	}
});

