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
/*
			if (this.mGame.mShapeArray)
			{
				for (i = 0; i < this.mGame.mShapeArray.length; i++)
				{
	
				}
			
			}
			//for (i = 0; i < this.mGame.mShapeArray.length; i++)
			//{
	//			if (this.mGame.mShapeArray[i].mMessage == 'bus_seat')			
//				{
//					mApplication.log('bus seat indhoue');	
	//			}
			//}
*/
	},
	
	onCollision: function(col)
	{
		this.parent(col);	
	}
});
