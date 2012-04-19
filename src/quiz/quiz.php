var Quiz = new Class(
{
        initialize: function(game,scoreNeeded,countBy,startNumber,endNumber)
        {
		//genre
		this.mGame = game;

		//score
                this.mScore = 0;
                this.mScoreNeeded = scoreNeeded;

		//question
		this.mQuestion = 0;		 

		//answer
		this.mAnswer = 0;

		//countBy
		this.mCount = 0;
		this.mCountBy = countBy;	
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;

        },

        update: function()
        {
        
	},

	reset: function()
	{
        	//score
                this.setScore(0);

                //game
                this.mQuestion = this.mCount;

                //count
                this.mCount = this.mStartNumber;

                //answer
                this.newAnswer();
	},

	//check answer
	checkAnswer: function(answer)
	{
		if (answer == this.mAnswer)
		{
			return true;
		}
		else
		{
			return false;
		}	
	},
       
	//questions
        newQuestion: function()
        {
                //set question
                this.mQuestion = this.mCount;
//		this.mGame.mHud.setQuestion(this.mQuestion);
        },

	getQuestion: function()
	{
		return this.mQuestion;
	},

        //new answer
        newAnswer: function()
        {
                this.mAnswer = this.mCount + this.mCountBy;
        },

	getAnswer: function()
	{
		return this.mAnswer;
	},

	getScore: function()
	{
		return this.mScore;
	},

	getScoreNeeded: function()
	{
		return this.mScoreNeeded;
	},
	
	setScore: function(score)
	{
		this.mScore = score;	
	},

	setScoreNeeded: function(scoreNeeded)
	{
		this.mScoreNeeded = scoreNeeded;
	},
	
	incrementScore: function()
	{
		this.mScore++;
	}
});


