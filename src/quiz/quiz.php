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
                this.mScoreHud       = new Shape("",140,50,0,150,"Score: " + this.getScore(),"pink","","hud");
                this.mScoreNeededHud = new Shape("",140,50,0,200,"Score Needed: " + this.getScoreNeeded(),"violet","","hud");
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
		this.mScoreHud.setText("Score: " + this.mScore);
	},

	setScoreNeeded: function(scoreNeeded)
	{
		this.mScoreNeeded = scoreNeeded;
		this.mScoreNeededHud.setText("Score Needed: " + this.mScoreNeeded);
	},

	incrementScore: function()
	{
		this.mScore++;
		this.mScoreHud.setText("Score: " + this.mScore);
	},

	reset: function()
	{
        	//score
                this.setScore(0);
		
		//reset marker
		this.mMarker = 0;
	}
});


