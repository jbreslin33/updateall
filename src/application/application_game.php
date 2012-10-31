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
		this.createQuiz(scoreNeeded);

        	//QUESTIONS FOR QUIZ
        	for (i = 0; i < scoreNeeded; i++)
        	{
                	var question = new Question(questions[i],answers[i]);
                	mQuiz.mQuestionArray.push(question);
        	}
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

	createQuiz: function(score_needed)
	{
        	mQuiz = new Quiz(score_needed);
        	mGame.mQuiz = mQuiz;
	},

        createControlObject: function(image_source)
        {
        
	},

        createQuestionShapes: function()
        {
        
	}
});

