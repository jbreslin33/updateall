var Player = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	correctAnswer: function()
	{
	},
	
	incorrectAnswer: function()
	{
	}
});

