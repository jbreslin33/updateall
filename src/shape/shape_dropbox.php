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
/*
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
                        if (answer == answerCol)
                        {
                               	this.correctAnswer();
                        }
                        else
                        {
                                this.incorrectAnswer();
                        }
                }
*/

 		//a dropbox_question recieving a pickup from a control object
		pickup = 0;
                if (col == this.mGame.mControlObject && col.mMounteeArray[0])
                {
                	pickup = col.mMounteeArray[0];

                        //have controlObject unMount pickup
                        col.unMount(0);
			
			//and you the dropbox pick it up
                        this.mount(pickup,0);
                }
	},

        mount: function(mountee,slot)
        {
		//this.parent(mountee,slot);
                //how bout an attempted mount before the real deal?
                //can i mount this thing? if so mount it.
                if (mountee.mMountable)
                {
                        if (this.mMountPointArray[0])
                        {
                                if (this.mMounteeArray[0])
                                {
                                        this.unMount(0);
                                }

                                if (mountee != this.getTimeoutShape())
                                {
                                        //first unmount  if you have something
                                        if (this.mMounteeArray[slot])
                                        {
                                                this.unMount(0);
                                        }

                                        //then mount
                                        this.mMounteeArray[slot] = mountee;
                                        this.mMounteeArray[slot].mountedBy(this,slot);
				
					if (this.mQuestion && this.mMounteeArray[slot].mQuestion)
					{
                        			answer = this.mQuestion.getAnswer();
                        			answerCol = col.mQuestion.getAnswer();

                        			//compare answers
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
                        }
                }
        },


});

