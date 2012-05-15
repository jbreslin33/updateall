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

		//questions
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
		this.mQuestionArray.push(new Question("4 + 3",7));
        }
	


});


