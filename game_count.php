<script type="text/javascript">

function GameCount(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	GameCount.baseConstructor.call(this,startNumber,scoreNeeded,countBy,numberOfButtons);

	//count
	this.countBy = countBy;
	this.count=0;
	this.startNumber = startNumber;
}

// subclass 
KInherit.extend(GameCount,Game);

//from game
GameCount.prototype.resetVariables = function()
{
        //Game.resetVariables();
//this.base().resetVariables();
GameCount.superClass.resetVariables();

        this.count = this.startNumber;
}

GameCount.prototype.checkGuess = function()
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



//overide
GameCount.prototype.newQuestion = function()
{
        //set question
        this.question = this.question + ' ' + this.count;
        document.getElementById("question").innerHTML=this.question;
}

GameCount.prototype.setChoices = function()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(offset);
}

GameCount.prototype.newAnswer = function()
{
        this.answer = this.count + this.countBy;
}

GameCount.prototype.setButtons = function(offset)
{
	i=1;
	for (i=1; i < this.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}

GameCount.prototype.submitGuess = function(button_id)
{
        this.guess = document.getElementById(button_id).innerHTML;
        
	this.checkGuess();
        this.printScore();
        this.newQuestion();
        this.newAnswer();
        this.setChoices();
}


</script>
