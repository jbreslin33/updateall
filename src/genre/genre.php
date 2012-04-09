var Genre = new Class(
{
        initialize: function(application, scoreNeeded, countBy, startNumber, endNumber)
        {
                //application
                this.mApplication = application;        

		//quiz	
		this.mQuiz = new Quiz(this,scoreNeeded,countBy,startNumber,endNumber);

        },

        update: function()
        {
        
	}

});


