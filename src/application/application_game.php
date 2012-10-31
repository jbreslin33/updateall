var ApplicationGame = new Class(
{

Extends: Application,

        initialize: function()
        {
                this.parent();

		//create bounds
		this.createBounds(60,735,380,35);

        	mHud = new Hud();
        	mHud.mScoreNeeded.setText('<font size="2"> Needed : ' + scoreNeeded + '</font>');
        	mHud.mGameName.setText('<font size="2">DUNGEON</font>');

        	//GAME
        	mGame = new Game("hardcode");

        	//QUIZ
        	mQuiz = new Quiz(scoreNeeded);
        	mGame.mQuiz = mQuiz;

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

        createControlObject: function(image_source)
        {
        
	},

        createQuestionShapes: function()
        {
        
	}
});

