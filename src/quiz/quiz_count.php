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
        
	initialize: function(scoreNeeded,countBy,startNumber,endNumber,game)
        {
		//parent
		this.parent(scoreNeeded);

		this.mGame = game;

		//countBy
		this.mCountBy = countBy;
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;

		for (i = this.mStartNumber; i <= this.mEndNumber; i = i + this.mCountBy)
		{
			this.mQuestionArray.push(new Question(i,i + this.mCountBy));
		}
		
		count = 0;
                for (i = this.mStartNumber + this.mCountBy; i <= this.mEndNumber; i = i + this.mCountBy)
                {
                        var openPoint = this.mGame.getOpenPoint2D(-400,400,-300,300,50,4);
                        this.mGame.addToShapeArray(new ShapeAnswer("",50,50,openPoint.mX,openPoint.mY,i,"yellow","","question",this.mGame,this.getSpecificQuestion(count)));
                        count++;
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


