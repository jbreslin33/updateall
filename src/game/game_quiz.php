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
        }

});
