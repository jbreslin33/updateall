var ShapeDoorLock = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message,srcOpen)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
		this.mOpen = false;	
		this.mSrcClosed = src;
		this.mSrcOpen = srcOpen;
        },

	update: function(delta)
        {
                if (this.mGame.mQuiz.isQuizComplete())
                {
                        if (this.mCollisionOn == false)
                        {
                                this.mCollisionOn = true;
                                this.setVisibility(true);
                        }
                }
                else
                {
                        if (this.mCollisionOn == true)
                        {
                                this.mCollisionOn = false;
                                this.setVisibility(false);
                        }
                }

                this.parent(delta);
        },

	onCollision: function(col)
	{
 		if (col == this.mGame.mControlObject)
                {
                	if (col.mMounteeArray[0])
                        {
                        	if (this.mMounteeArray[0].mQuestion.getAnswer() == col.mMounteeArray[0].mQuestion.getAnswer())
                                {
                               		this.correctAnswer();
                                }
                                else
                                {
                                        this.incorrectAnswer();
                                }
                        }
                }
		
	},

	correctAnswer: function()
	{
		this.mOpen = true;	
		this.setSrc(this.mSrcOpen);

                this.mGame.mOn = false;
                window.location = "/src/database/goto_next_level.php";
	}	 
});

