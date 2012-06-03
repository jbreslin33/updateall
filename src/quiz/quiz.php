/***************************************
public methods
----------------

//get methods
score       getScore(); //returns current score
scoreNeeded getScoreNeeded();

//set methods
void setScore();
void setScoreNeeded(scoreNeeded);
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

		/******************** HUD ********************/
                this.mScoreHud       = new Shape(100,60,0,230,mGame,"","","cyan","hud");
                //this.mScoreNeededHud = new Shape(100,40,0,270,mGame,"","","#B799CD","hud");
		//this.setScoreNeeded(this.mScoreNeeded);
			
		this.mQuestionHud;
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
               	if (this.mQuestionHud)
		{ 
			this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
		}
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
		this.mScoreHud.setText("Score: " + this.mScore + '\n' + 'Score Needed:' + this.mScoreNeeded);
	},

	setScoreNeeded: function(scoreNeeded)
	{
		this.mScoreNeeded = scoreNeeded;
		this.mScoreNeededHud.setText("Needed: " + this.mScoreNeeded);
	},

	incrementScore: function()
	{
		this.mScore++;
		this.mScoreHud.setText("Score:       " + this.mScore + '\n' + 'Score Needed:' + this.mScoreNeeded);
		//this.mScoreHud.setText("Score: " + this.mScore);
	},

	reset: function()
	{
        	//score
                this.setScore(0);
		
		//reset marker
		this.mMarker = 0;
                
		//update hud
               	if (this.mQuestionHud)
		{ 
			this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
		}
	}

});


