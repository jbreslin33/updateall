var Hud = new Class(
{

        initialize: function(game)
        {
                //shape Array
                this.mShapeArray = new Array();

	        //On_Off
                this.mOn = true;
        
                // id counter
                this.mIdCount = 0;

        },

        update: function()
        {
                if (this.mOn)
                {
                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
                        	this.mShapeArray[i].update();
                	}
                }
        },

	createHud: function()
	{
		new Shape(this,"",50,50,300,300,false,false,"",false,false,false,"U","green","","normal");
	},	

        //reset
        resetHud: function()
        {
        
	}
});


