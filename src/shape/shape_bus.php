var ShapeBus = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

        update: function(delta)
        {
       		this.parent(delta); 

	},
	
	onCollision: function(col)
	{
		this.parent(col);	
	}
});
