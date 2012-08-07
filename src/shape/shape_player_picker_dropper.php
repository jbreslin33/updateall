var PlayerPickerDropper = new Class(
{

Extends: Player,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	onCollision: function(col)
	{
		mApplication.log("onCol");
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
	}
});

