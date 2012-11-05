var ShapeDropBox = new Class(
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
                }

		this.parent();
	},

	onCollision: function(col)
	{
    		this.mPosition.mX = this.mPositionOld.mX;
                this.mPosition.mY = this.mPositionOld.mY;

                //evaluate answers to questions provided both shapes have questions.
                var answer = 0;
                var answerCol = 0;

                if (this.mQuestion && col.mQuestion)
                {
                        answer = this.mQuestion.getAnswer();
		        mApplication.log('answer:' + answer);	
                        answerCol = col.mQuestion.getAnswer();
		        mApplication.log('answerCol:' + answerCol);	

                        //compare answers
                        if (this.mQuestion.getSolved() == false)
                        {
		        	mApplication.log('not solved');	
                                if (answer == answerCol)
                                {
					mApplication.log('correct in shape_box');
					this.mQuestion.setSolved(true);
                                        this.correctAnswer();
                                }
                                else
                                {
                                        this.incorrectAnswer();
                                }
                        }
                }

 		//a dropbox_question recieving a pickup from a control object
		pickup = 0;
                if (col == this.mGame.mControlObject && col.mMounteeArray[0])
                {
			mApplication.log('here');
                	pickup = col.mMounteeArray[0];

                        //have controlObject unMount pickup
                        col.unMount(0);
			
			//and you the dropbox pick it up
                        this.mount(pickup,0);
	
			//set timeout so we don't collide again...
		//	this.setTimeoutShape(col);
                }
	}
});

