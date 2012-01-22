<script type="text/javascript">

<?php echo "var agame = new game($startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?>
 

function game(startNumber,scoreNeeded,countBy,numberOfButtons)
{

//vars
this.startNumber = startNumber;
this.scoreNeeded = scoreNeeded;
this.countBy = countBy;
this.numberOfButtons = numberOfButtons;
this.question="";
this.guess=0;
this.count=0;
this.answer=0;
this.score=0;


}


function gameCount()
{

}

gameCount.prototype = new game(<?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons"; ?> );


game.prototype.printScore = function()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

game.prototype.checkForEndOfGame = function()
{
        if (this.score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}
game.prototype.resetVariables = function()
{
        this.question = "";
       	this.count = this.startNumber; 

	this.guess = 0;
        this.answer = 0;
        this.score = 0;
}

game.prototype.checkGuess = function()
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

        this.printScore();

        this.newQuestion();
        this.newAnswer();
        this.setChoices();
}

game.prototype.submitGuess = function(button_id)
{
        this.guess = document.getElementById(button_id).innerHTML;
        this.checkGuess();
}

//overide
game.prototype.newQuestion = function()
{
        //set question
        this.question = this.question + ' ' + this.count;
        document.getElementById("question").innerHTML=this.question;
}

game.prototype.setChoices = function()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(offset);
}

game.prototype.newAnswer = function()
{
        this.answer = this.count + this.countBy;
}

game.prototype.setButtons = function(offset)
{
	i=1;
	for (i=1; i < this.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}



</script>
