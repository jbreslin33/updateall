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


/*
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
                        answerCol = col.mQuestion.getAnswer();

                        //compare answers
                        if (this.mQuestion.getSolved() == false)
                        {
                                if (answer == answerCol)
                                {
                                        this.correctAnswer();
                                }
                                else
                                {
                                        this.incorrectAnswer();
                                }
                        }
                }

                //can i mount this thing? if so mount it.
                if (col.mMountable)
                {
                        if (this.mMountPointArray[0])
                        {
                                if (this.mMounteeArray[0])
                                {
                                        this.unMount(0);
                                }
                                this.mount(col,0);
                        }
                }
        },
*/
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
                        answerCol = col.mQuestion.getAnswer();

                        //compare answers
                        if (this.mQuestion.getSolved() == false)
                        {
                                if (answer == answerCol)
                                {
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
/*                       
			//now that you the dropbox have picked up something from control object let's check if it's correct or incorrect IF IT HAS A QUESTION	
			if (this.mMounteeArray[0])
			{
				if (this.mMounteeArray[0].mQuestion && this.mQuestion && this.mGame.mQuiz)
                       		{
                             		if (this.mMounteeArray[0].mQuestion.getAnswer() == this.mQuestion.getAnswer())
                              		{
						this.correctAnswer();
						mApplication.log('correctamundo');
                              		}
                              		else
                              		{
						this.mGame.resetGame();
                              		}
				}
			}
*/
                }
	}
});

