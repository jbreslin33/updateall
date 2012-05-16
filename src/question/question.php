/***************************************
public methods
----------------

//get methods
answer      getAnswer(); returns current answer
question    getQuestion(); //returns current score

//set methods
void setAnswer(answer);
void setQuestion(question);

****************************************/

var Question = new Class(
{
        initialize: function(question,answer)
        {
		//question
		this.mQuestion = question;

		//answer
		this.mAnswer = answer;
        },

	setQuestion: function(question)
	{
		mQuestion = question;
	},

	setAnswer: function(answer)
	{
		mAnswer = answer;
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


