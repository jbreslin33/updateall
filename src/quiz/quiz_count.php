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
		this.mCount = 0;
		this.mCountBy = countBy;
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;

		this.mQuestion1 = new Question(0,1);
		this.mQuestion2 = new Question(1,2);
		this.mQuestion3 = new Question(2,3);
		this.mQuestion4 = new Question(3,4);
		this.mQuestion5 = new Question(4,5);
		this.mQuestion6 = new Question(5,6);
		this.mQuestion7 = new Question(6,7);
		this.mQuestion8 = new Question(7,8);
		this.mQuestion9 = new Question(8,9);
		this.mQuestion10 = new Question(9,10);

		this.mQuestionArray.push(this.mQuestion1);
		this.mQuestionArray.push(this.mQuestion2);
		this.mQuestionArray.push(this.mQuestion3);
		this.mQuestionArray.push(this.mQuestion4);
		this.mQuestionArray.push(this.mQuestion5);
		this.mQuestionArray.push(this.mQuestion6);
		this.mQuestionArray.push(this.mQuestion7);
		this.mQuestionArray.push(this.mQuestion8);
		this.mQuestionArray.push(this.mQuestion9);
		this.mQuestionArray.push(this.mQuestion10);
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
			mApplication.log('useranswer=' + answer);
			mApplication.log('realanswer=' + this.mQuestionArray[this.mMarker].getAnswer());
		if (this.mQuestionArray[this.mMarker].submitAnswer(answer))
		{
			this.mMarker++;
                	this.mCount = this.mCount + this.mCountBy;  //add to count
                        this.incrementScore();
			this.mQuestionHud.setText("Question: " + this.mQuestionArray[this.mMarker].getQuestion());
			return true;
		}
		else
		{
			return false;
		}
	}

});


