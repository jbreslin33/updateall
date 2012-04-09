var Quiz = new Class(
{
        initialize: function(genre,scoreNeeded,countBy,startNumber,endNumber)
        {
		//genre
		this.mGenre = genre;

		//score
                this.mScore = 0;
                this.mScoreNeeded = scoreNeeded;

		//question
		this.mQuestion = 0;		 

		//answer
		this.mAnswer = 0;

		//countBy
		this.mCount = 0;
		this.mCountBy = countBy;	
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber;

        },

        update: function()
        {
        
	},
       
	//questions
        newQuestion: function()
        {
                //set question
                this.mQuestion = this.mCount;
                document.getElementById("question").innerHTML="Question: " + this.mQuestion;
                this.mGenre.mShapeArray[0].setText(this.mCount);
        },

        //new answer
        newAnswer: function()
        {
                this.mAnswer = this.mCount + this.mCountBy;
        },

        //Score
        printScore: function()
        {
                document.getElementById("score").innerHTML="Score: " + this.mScore;
                document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.mScoreNeeded;
        }

});


