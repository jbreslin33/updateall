var Player = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	update: function(delta)
	{
		this.parent(delta);

                this.mGame.mControlObject.setQuestion(this.mGame.mQuiz.getQuestion());
                if (this.mMounteeArray[0])
                {
                        this.mMounteeArray[0].setQuestion(this.mGame.mQuiz.getQuestion());
                }
	},	
	
	correctAnswer: function()
	{

	},
	
	incorrectAnswer: function()
	{
	}
});
