/***************************************
public methods
----------------

//get methods
count       getCount(); returns current answer
countBy     getCountBy(); //returns current score
startNumber getStartNumber();
endNumber   getEndNumber();

//set methods
void setCount(count);
void setCountBy(countBy);
void setStartNumber(startNumber);
void setEndNumber(endNumber);

****************************************/

var QuizCount = new Class(
{

Extends: Quiz,
        
	initialize: function(game,scoreNeeded,countBy,startNumber,endNumber)
        {
		//parent
		this.parent(game,scoreNeeded);

		//countBy
		this.mCount = 0;
		this.mCountBy = countBy;
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;
        },

	getGame: function()
	{
		return mGame;
	},

	reset: function()
	{
                //count
                this.mCount = this.mStartNumber;
	
		this.parent();	
	},

	//submit answer
	submitAnswer: function(answer)
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

        //new answer
        newAnswer: function()
        {
                this.mAnswer = this.mCount + this.mCountBy;
        }

});


