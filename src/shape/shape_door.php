var ShapeDoor = new Class(
{

Extends: Shape,

        initialize: function(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message)
        {
        	this.parent(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
		this.mOpen = false;	
        },

 	updateVelocity: function(delta)
        {
                this.update();
		this.parent(delta);		
        },

        update: function(delta)
        {
                //run ai
		if (this.mGame.mQuiz.isQuizComplete())
		{
			if (this.mOpen == false)
			{
				this.mOpen = true;
				this.setSrc("/images/doors/door_open.png");
			}
		}
		else
		{
			if (this.mOpen)
			{
				this.mOpen = false;
				this.setSrc("/images/doors/door_closed.png");
			}

		}
        }

});

