<script type="text/javascript">

function Game(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	//score
	this.score=0;
	this.scoreNeeded = scoreNeeded;

	//game
	this.numberOfButtons = numberOfButtons;
	this.question="";
	this.guess=0;
	this.answer=0;

	//count
	this.countBy = countBy;
	this.count=0;
	this.startNumber = startNumber;
}


//Score
Game.prototype.printScore = function()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

Game.prototype.checkForEndOfGame = function()
{
        if (this.score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

//reset
Game.prototype.resetVariables = function()
{
	//score
	this.score = 0;

	//game
        this.question = "";
        this.guess = 0;
        this.answer = 0;

	//count
        this.count = this.startNumber;
}

//check guess
Game.prototype.checkGuess = function()
{
        if (this.guess == this.answer)
        {
                this.count = this.count + this.countBy;  //add to count
                this.score++;

                document.getElementById("feedback").innerHTML="Correct!";

                this.checkForEndOfGame();
        }
        else
        {
                document.getElementById("feedback").innerHTML="Wrong! Try again.";

                this.resetVariables();
        }
}

//questions
Game.prototype.newQuestion = function()
{
        //set question
        this.question = this.question + ' ' + this.count;
        document.getElementById("question").innerHTML=this.question;
}

//set choices
Game.prototype.setChoices = function()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(offset);
}

//new answer
Game.prototype.newAnswer = function()
{
        this.answer = this.count + this.countBy;
}

//set buttons
Game.prototype.setButtons = function(offset)
{
	i=1;
	for (i=1; i < this.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}

//submit guess
Game.prototype.submitGuess = function(button_id)
{
        this.guess = document.getElementById(button_id).innerHTML;
        
	this.checkGuess();
        this.printScore();
        this.newQuestion();
        this.newAnswer();
        this.setChoices();
}


</script>
