var Genre = new Class(
{
        initialize: function(application, scoreNeeded)
        {
                //application
                this.mApplication = application;        

		//quiz	
		this.mQuiz = new Quiz(scoreNeeded);

        },

        update: function()
        {
        
	}

});


