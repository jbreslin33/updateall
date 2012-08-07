var ShapeDropbox = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	reset: function()
	{

		if (this.mMounteeArray[0])
                {
                        this.mMounteeArray[0].mMounter = 0;
                        this.mMounteeArray[0] = 0;
                }

		this.parent();
	},
	
	onCollision: function(col)
	{
 		//a dropbox_question recieving a pickup from a control object
		pickup = 0;
                if (col == this.mGame.mControlObject && col.mMounteeArray[0])
                {
			mApplication.log("here");
                	pickup = col.mMounteeArray[0];

                        //have controlObject unMount pickup
                        col.unMount(0);
                        this.mount(pickup,0);
                       	
			if (this.mMounteeArray[0])
			{
				if (this.mMounteeArray[0].mQuestion && this.mQuestion && this.mGame.mQuiz)
                       		{
                             		if (this.mMounteeArray[0].mQuestion.getAnswer() == this.mQuestion.getAnswer())
                              		{
						this.mGame.mQuiz.correctAnswer();
                              		}
                              		else
                              		{
						this.mGame.resetGame();
                              		}
				}
			}
                }
	}
});

