/***************************************
public methods
----------------

//get methods
score       getScore(); //returns current score
scoreNeeded getScoreNeeded();

//set methods
void setQuestions(arrayOfQuestions);

void incrementScore();
void addQuestion(question); //question answer pair to add to end of question/answer arrays.
void randomizeQuestions();

****************************************/

var Quiz = new Class(
{
        initialize: function(scoreNeeded)
        {
		//Question and Answer Array
		this.mQuestionArray = new Array();
			
		//score
                this.mScore = 0;
                this.mScoreNeeded = scoreNeeded;

		//question
		this.mMarker = 0;
        },

	//returns question object	
	getQuestion: function()
	{
		return this.mQuestionArray[this.mMarker];
	},

	//returns question object	
	getSpecificQuestion: function(i)
	{
		return this.mQuestionArray[i];
	},
	
	correctAnswer: function()
	{
        	this.incrementScore();
		this.mMarker++;
	
		mHud.mQuestion.setText('<font size="2"> Question: ' + this.mQuestionArray[this.mMarker].getQuestion() + '</font>');
	},
	
	getScore: function()
	{
		return this.mScore;
	},

	getScoreNeeded: function()
	{
		return this.mScoreNeeded;
	},

	isQuizComplete: function()
	{
		if (this.getScore() >= this.getScoreNeeded())
		{
			return true;
		}
		else
		{
			return false;
		}
	},

	setScore: function(score)
	{
		this.mScore = score;
		mHud.mScore.setText('<font size="2">Score: ' + this.mScore + '</font>');
	},

	setScoreNeeded: function(scoreNeeded)
	{
		this.mScoreNeeded = scoreNeeded;
		mHud.mScoreNeeded.setText('<font size="2"> Needed: ' + this.mScoreNeeded + '</font>');
	},

	incrementScore: function()
	{
		this.mScore++;
		mHud.mScore.setText('<font size="2"> Score : ' + this.mScore + '</font>');
	},

	reset: function()
	{
        	//score
                this.setScore(0);
		
		//reset marker
		this.mMarker = 0;
                
		//update question 
		mHud.mQuestion.setText('<font size="2"> Question: ' + this.mQuestionArray[this.mMarker].getQuestion() + '</font>');
	}
});


