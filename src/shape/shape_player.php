var Player = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	correctAnswer: function()
	{
        	//set text of control object
                if (this.mGame.mQuiz)
                {
                	//set the control objects question object
                        this.mGame.mControlObject.setQuestion(this.mGame.mQuiz.getQuestion());
                        if (this.mMounteeArray[0])
                        {
                                this.mMounteeArray[0].setQuestion(this.mGame.mQuiz.getQuestion());
                        }
                }
	},
	
	incorrectAnswer: function()
	{
	}
});
