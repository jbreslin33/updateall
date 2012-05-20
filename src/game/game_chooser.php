var GameChooser = new Class(
{

Extends: Game,

        initialize: function(skill)
        {
                //application
                this.parent(skill);
        },

	resetGame: function()
	{
		this.parent();

		//let's reset all quiz stuff right here.
                if (this.mQuiz)
		{ 
			this.mQuiz.reset();
		}
	},
	
	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);

		//you ran into a question shape lets resolve it	
		if (col1.mMessage == "controlObject" && col2.mMessage == "question")
		{
                        if (this.mQuiz)
			{ 
				mApplication.log('complete');
                       		this.mOn = false;
                             	this.setFeedback("YOU CHOSE WELL!!!");
				window.location = col2.mQuestion.getAnswer();
				
			}	
                }
 	}).protect()

});



