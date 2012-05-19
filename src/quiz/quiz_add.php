/***************************************
public methods
----------------

//get methods

//set methods
****************************************/

var QuizAdd = new Class(
{

Extends: Quiz,
        
	initialize: function(scoreNeeded,addendMin,addendMax,numberOfAddends,game)
        {
		//parent
		this.parent(scoreNeeded);

		this.mGame = game;

		//countBy
		this.mAddendMin = addendMin;
		this.mAddendMax = addendMax;
                this.mNumberOfAddends = numberOfAddends;

		for (i = 0; i < this.mScoreNeeded; i++)
		{
			seed = addendMax - addendMin + 1;
			result1 = Math.floor(Math.random()*seed);
			result2 = Math.floor(Math.random()*seed);
			addend1 = result1 + addendMin;
			addend2 = result2 + addendMin;
			answer = addend1 + addend2;
			this.mQuestionArray.push(new Question(addend1 + ' + ' + addend2, answer));
		}
		
		count = 0;
                for (i = 0; i < this.mScoreNeeded; i++)
                {
                        var openPoint = this.mGame.getOpenPoint2D(-400,400,-300,300,50,4);
                        this.mGame.addToShapeArray(new Shape(this.mGame,"relative",this.getSpecificQuestion(count),"",50,50,openPoint.mX,openPoint.mY,i,"yellow","","question"));
                        count++;
                }
        },
	
	correctAnswer: function()
	{
		this.incrementScore();
	}

});


