var ShapeDropbox = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	update: function(delta)
	{
		this.mQuestion = this.mGame.mQuiz.getQuestion();
		this.parent(delta);

	},	

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
				mApplication.log('a:' + this.mMountee.mQuestion.getAnswer());
				mApplication.log('b:' + this.mQuestion.getAnswer());
                             	if (this.mMountee.mQuestion.getAnswer() == this.mQuestion.getAnswer())
                              	{
					this.mGame.mQuiz.correctAnswer();
//					this.mQuestion = this.mGame.mQuiz.getQuestion();   
                              	}
                              	else
                              	{
					this.mGame.resetGame();
                              	}
			}
                }
	}
});

