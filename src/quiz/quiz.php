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

		/******************** HUD ********************/
                this.mScoreHud       = new Shape(this.mGame,"",140,50,0,150,"Score: " + this.getScore(),"pink","","normal","hud");
                this.mScoreNeededHud = new Shape(this.mGame,"",140,50,0,200,"Score Needed: " + this.getScoreNeeded(),"violet","","normal","hud");
                this.mQuestionHud    = new Shape(this.mGame,"",140,50,0,250,"Question:","violet","","normal","hud");

        },

	getGame: function()
	{
		return mGame;
	},

	create: function()
	{
                //these are the questions. SHould they not be created in the quiz? and then either updated there like i do with hud or in game as normal.
                for (i = this.mStartNumber + this.mCountBy; i <= this.mEndNumber; i = i + this.mCountBy)
                {
                        this.mGame.setUniqueSpawnPosition();
                        new ShapeCollidable(this.mGame,"",50,50,this.mGame.mPositionXArray[this.mGame.mProposedX],this.mGame.mPositionYArray[this.mGame.mProposedY],i,"yellow","","relative","question");
                }

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
                	this.mCount = this.mCount + this.mCountBy;  //add to count
                        this.incrementScore();

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
		this.mScoreHud.setText("Score: " + this.mScore);
	}

});


