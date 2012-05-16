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
        
	initialize: function(scoreNeeded,countBy,startNumber,endNumber)
        {
		//parent
		this.parent(scoreNeeded);

		//countBy
		this.mCountBy = countBy;
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;

		for (i = this.mStartNumber; i <= this.mEndNumber; i = i + this.mCountBy)
		{
			this.mQuestionArray.push(new Question(i,i + this.mCountBy));
		}
		
		/******************** HUD ********************/
                this.mQuestionHud    = new Shape("",140,50,0,250,"Question:","violet","","hud");

        },

	reset: function()
	{
		this.parent();	
                
	  	//update hud
                this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
	
	},

	correctAnswer: function()
	{
		this.parent();
		this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
	}

});


