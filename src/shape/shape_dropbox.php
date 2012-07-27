var ShapeDropbox = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	onCollision: function(col)
	{
 		//a dropbox_question recieving a pickup from a control object
                if (col == this.mGame.mControlObject)
                {
                        //check for correct answer
                        if (col.mMountee)
                        {
                                if (col.mMountee.mQuestion && this.mQuestion)
                                {
                                        if (col.mMountee.mQuestion.getAnswer() == this.mQuestion.getAnswer())
                                        {
                                                this.mGame.correctAnswer(col,this);
                                        }
                                        else
                                        {
                                                //this deletes and then recreates everthing.
                                                this.mGame.incorrectAnswer(col,this);
                                        }
                                }
                        }

                        //have the dropbox_question pick up the pickup from controlobject
                        pickup = 0;
                        if (col.mMountee)
                        {
                                if (col.mMountee.mMessage == "pickup")
                                {
                                        pickup = col.mMountee;

                                        //have controlObject unMount pickup
                                        col.unMount(pickup);
                                        this.mount(pickup,0);
                                }
                        }
                }
	}
});

