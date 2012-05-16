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
		this.mQuestionArray.push(new Question("4 + 2",6));
		this.mQuestionArray.push(new Question("4 + 1",5));
		this.mQuestionArray.push(new Question("2 + 2",4));
		this.mQuestionArray.push(new Question("3 + 3",6));
		this.mQuestionArray.push(new Question("1 + 1",2));
		this.mQuestionArray.push(new Question("2 + 3",5));
		this.mQuestionArray.push(new Question("4 + 4",8));
		this.mQuestionArray.push(new Question("2 + 1",3));
		this.mQuestionArray.push(new Question("0 + 3",3));
        }
});


