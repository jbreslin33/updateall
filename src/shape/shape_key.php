var ShapeKey = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message,srcOpen)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
		this.mMountable = true;
        },

        update: function(delta)
        {
		this.parent(delta);
        }

});

