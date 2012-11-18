var GameQuiz = new Class(
{

Extends: Game,

	initialize: function()
	{
       		this.parent();

                /************** QUIZ **********/
                this.mQuiz = 0;
	},

        resetGame: function()
        {
		this.parent();

                if (this.mQuiz)
                {
                        this.mQuiz.reset();
                }
        },
        update: function()
        {
                if (this.mOn)
                {
			this.parent();

                        //check for quiz complete
                        if (this.mQuiz)
                        {
                                if (this.mQuiz.isQuizComplete())
                                {
                                        // update score one last time
                                        this.updateScore();
                                        // set game end time
                                        this.quizComplete();
                                        // putting this in for now we may not need it
                                        this.gameOver = true;
                                }
                        }
                }
        },

        createQuestions: function()
        {
                for (i = 0; i < scoreNeeded; i++)
                {
                        var question = new Question(questions[i],answers[i]);
                        this.mQuiz.mQuestionArray.push(question);
                }
        },

        createControlObject: function(image_source)
        {
                //*******************CONTROL OBJECT
                this.mControlObject = new Player(50,50,400,300,this,this.mQuiz.getSpecificQuestion(0),image_source,"","controlObject");

                //set animation instance
                this.mControlObject.mAnimation = new AnimationAdvanced(this.mControlObject);
                this.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');
                this.addToShapeArray(this.mControlObject);

                this.mControlObject.mHideOnQuestionSolved = false;
                this.mControlObject.createMountPoint(0,-5,-41);
        }


});
