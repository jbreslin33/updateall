var ShapeChaser = new Class(
{

Extends: ShapeAI,

        initialize: function(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message)
        {
        	this.parent(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
        },

	onCollision: function(col)
        {
		this.parent(col);
                if (col == this.mGame.mControlObject)
                {
			this.mGame.resetGame();
                }
        },
	
	correctAnswer: function()
	{
	},
	
	incorrectAnswer: function()
	{
	}
});

