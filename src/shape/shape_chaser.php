var ShapeChaser = new Class(
{

Extends: ShapeAI,
 	initialize: function(width,height,spawnX,spawnY,game,src,backgroundColor,message)

//        initialize: function(game,drawType,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message)
        {
		this.parent(width,height,spawnX,spawnY,game,src,backgroundColor,message);

        	//this.parent(game,drawType,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
        },

	onCollision: function(col)
        {
		this.parent(col);
                if (col == this.mGame.mControlObject)
                {
			this.mGame.resetGame();
                }
        }
});

