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

var QuizAdd = new Class(
{

Extends: Quiz,
        
	initialize: function(scoreNeeded,startNumber,endNumber)
        {
		//parent
		this.parent(scoreNeeded);

		//countBy
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;
        },

	reset: function()
	{
		this.parent();	
	},

	//submit answer
	submitAnswer: function(answer)
	{
		if (answer == this.mAnswer)
		{
                        this.incrementScore();
			return true;
		}
		else
		{
			return false;
		}
	},

        newQuestion: function()
        {
                //set question
                //this.mQuestion = this.mCount;
		//needs to be random
		//this.mQuestion
		//this.mQuestionHud.setText("Question: " + this.mQuestion);

		//a new question needs a new answer
       		//this.newAnswer();
	},

        //new answer
        newAnswer: function()
        {
                //this.mAnswer = this.mCount + this.mCountBy;
		//this needs to be random
		this.mAnswer = 1;
        }

});


