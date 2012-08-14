var PutKidsOnTheBus = new Class(
{

Extends: Game,
        initialize: function(skill)
        {
                this.parent(skill)
		this.mKidsOnBus = 0;
        },
	
        update: function()
        {
		this.parent();
       		if (this.mOn)
		{
			//do someting
			kidsOnBus = 0;
			for (i = 0; i < this.mShapeArray.length; i++)
			{
				if (this.mShapeArray.mMessage == 'kid')
				{
					kidsOnBus++;	
				}				
			}
			this.mKidsOnTheBus = kidsOnBus;
		}
	}

});


