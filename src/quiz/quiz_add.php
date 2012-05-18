/***************************************
public methods
----------------

//get methods

//set methods
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
 Math.floor( Math.random()*xSize) 
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

		mApplication.log('min:' + this.mAddendMin);
		mApplication.log('max:' + this.mAddendMax);

		for (i = 0; i <= this.mScoreNeeded; i++)
		{
			seed = addendMax - addendMin;
			result1 = Math.floor(Math.random()*seed);
			result2 = Math.floor(Math.random()*seed);
			addend1 = result1 + addendMin;
			addend2 = result2 + addendMin;
			answer = addend1 + addend2;
			this.mQuestionArray.push(new Question(addend1 + ' + ' + addend2, answer));
		}
		
		count = 0;
                for (i = 0; i <= this.mScoreNeeded; i++)
                {
                        var openPoint = this.mGame.getOpenPoint2D(-400,400,-300,300,50,4);
                        this.mGame.addToShapeArray(new ShapeQuestion("",50,50,openPoint.mX,openPoint.mY,i,"yellow","","question",this.mGame,this.getSpecificQuestion(count)));
                        count++;
                }
	

	
		/******************** HUD ********************/
                this.mQuestionHud    = new Shape("",140,50,0,250,"Question:","violet","","hud");

        },
	
	createQuiz: function()
	{

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


