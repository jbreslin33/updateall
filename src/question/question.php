var Question = new Class(
{
        initialize: function(question,answer)
        {
		//question
		this.mQuestion = question;

		//answer
		this.mAnswer = answer;
        },
	
	set: function(question,answer)
	{
		this.mQuestion = question;
		this.mAnswer = answer;
	},

	setQuestion: function(question)
	{
		this.mQuestion = question;
	},

	setAnswer: function(answer)
	{
		this.mAnswer = answer;
	},	

	getQuestion: function()
	{
		return this.mQuestion;
	},

	getAnswer: function()
	{
		return this.mAnswer;
	}

});


