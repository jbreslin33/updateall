/****************************************************************

Does nothing right now. Eventually I envision this tying all classes
together. I.e. this should instantiate application etc...

***************************************************************/

var Game = new Class(
{
        initialize: function()
        {
       		//application
			 
	},

        update: function()
        {
		mApplication.update();	
		var t=setTimeout("mGame.update()",20)
	}

});


