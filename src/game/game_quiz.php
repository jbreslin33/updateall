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
        }
});
