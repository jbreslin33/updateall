var ShapeDropbox = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	reset: function()
	{

		if (this.mMountee)
                {
			mApplication.log('col true');
                	this.mMountee.mCollidable = true;
                        this.mMountee.mMounter = 0;
                        this.mMountee = 0;
                }

		this.parent();
	},
/*
          //set every shape to spawn position
                this.mPosition.mX = this.mPositionSpawn.mX;
                this.mPosition.mY = this.mPositionSpawn.mY;
                this.setVisibility(true);

                if (this.mCollidable == true)
                {
                        this.mCollisionOn = true;
                }
*/
	onCollision: function(col)
	{
 		//a dropbox_question recieving a pickup from a control object
		pickup = 0;
                if (col == this.mGame.mControlObject && col.mMountee && col.mMountee.mMessage == "pickup")
                {
                	pickup = col.mMountee;

                        //have controlObject unMount pickup
                        col.unMount(pickup);
                        this.mount(pickup,0);
                       	
			if (this.mMountee.mQuestion && this.mQuestion && this.mGame.mQuiz)
                       	{
                             	if (this.mMountee.mQuestion.getAnswer() == this.mQuestion.getAnswer())
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
});

