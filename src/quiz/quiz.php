/***************************************
public methods
----------------

//get methods
answer      getAnswer(); returns current answer
score       getScore(); //returns current score
scoreNeeded getScoreNeeded();

//set methods
void setAnswers(arrayOfAnswers);
void setScore();
void setQuestions(arrayOfQuestions);
void setScoreNeeded(scoreNeeded);

void addQuestion(question,answer); //question answer pair to add to end of question/answer arrays.

void randomizeQuestions();
void incrementScore();

bool submitAnswer(answer);  //returns whether answer is correct

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
                this.mQuestionHud    = new Shape("",140,50,0,250,"Question:","violet","","hud");
        },

	reset: function()
	{
        	//score
                this.setScore(0);
		
		//reset marker
		this.mMarker = 0;
		
		//update hud	
		this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
	},

	//submit answer
	submitAnswer: function(answer)
	{
		if (answer == this.mAnswer)
		{
                        this.incrementScore();
			this.mMarker++;
			this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
			return true;
		}
		else
		{
			return false;
		}
	},

	getQuestion: function()
	{
		return this.mQuestionArray[this.mMarker];
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
	}

});


