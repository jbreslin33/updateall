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
        initialize: function(game,scoreNeeded)
        {
		//genre
		this.mGame = game;

		//Question and Answer Array
		this.mQuestionArray = new Array();
		this.mQuestionArray[0] = 0;	
		this.mAnswerArray   = new Array();
		this.mAnswerArray[0] = 0;	
			
	
		//score
                this.mScore = 0;
                this.mScoreNeeded = scoreNeeded;

		//question
		this.mMarker = 0;
		this.mQuestion = 0;

		//answer
		this.mAnswer = 0;

		/******************** HUD ********************/
                this.mScoreHud       = new Shape("",140,50,0,150,"Score: " + this.getScore(),"pink","","hud");
                this.mScoreNeededHud = new Shape("",140,50,0,200,"Score Needed: " + this.getScoreNeeded(),"violet","","hud");
                this.mQuestionHud    = new Shape("",140,50,0,250,"Question:","violet","","hud");
        },

	getGame: function()
	{
		return this.mGame;
	},

	reset: function()
	{
        	//score
                this.setScore(0);
		
                //question	
                this.mQuestion = this.mQuestionArray[0];
		this.mQuestionHud.setText("Question: " + this.mQuestion);

                //answer
                this.newAnswer();
	},

	//submit answer
	submitAnswer: function(answer)
	{
		if (answer == this.mAnswer)
		{
                        this.incrementScore();
			this.mMarker++;
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
                this.mQuestion = this.mQuestionArray[this.mMarker];

		this.mQuestionHud.setText("Question: " + this.mQuestion);

		//a new question needs a new answer
       		this.newAnswer();
	},

	getQuestion: function()
	{
		return this.mQuestion;
	},

        //new answer
        newAnswer: function()
        {
                this.mAnswer = this.mAnswerArray[this.mMarker];
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


