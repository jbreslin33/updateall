var Player = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	onCollision: function(col)
	{
		//can i mount this thing? 
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

        	else if (col.mMounteeArray[0])
                {

                	if (this.mMounteeArray[0] && this.mMounteeArray[0].mQuestion)
                        {
                        	if (this.mMounteeArray[0].mQuestion.getAnswer() == col.mQuestion.getAnswer())
                                {
                                	//mark as correct
                                        col.correctAnswer();

                                        //now get me off the screen
                                        col.mCollisionOn = false;
                                        col.setVisibility(false);
                                }
                                else
                                {
                                        col.incorrectAnswer();
                                }
                        }
                }
	}
});

