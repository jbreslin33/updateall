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
			this.unMount(0);
                        //this.mMounteeArray[0].mMounter = 0;
                        //this.mMounteeArray[0] = 0;
                }

		this.parent();
	},
	
	onCollision: function(col)
	{
 		//a dropbox_question recieving a pickup from a control object
		pickup = 0;
                if (col == this.mGame.mControlObject && col.mMounteeArray[0])
                {
                	pickup = col.mMounteeArray[0];

                        //have controlObject unMount pickup
                        col.unMount(0);
			
			//and you the dropbox pick it up
                        this.mount(pickup,0);
                       
			//now that you the dropbox have picked up something from control object let's check if it's correct or incorrect	
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

