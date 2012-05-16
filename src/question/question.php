/***************************************
public methods
----------------

//get methods
answer      getAnswer(); returns current answer
question    getQuestion(); //returns current score

//set methods
void setAnswer(answer);
void setQuestion(question);

bool submitAnswer(answer);  //returns whether answer is correct

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

	//submit answer
	submitAnswer: function(answer)
	{
		if (answer == this.mAnswer)
		{
			return true;
		}
		else
		{
			return false;
		}
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


