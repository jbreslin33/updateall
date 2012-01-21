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

//class functions
this.resetVariables=resetVariables;
this.setButtons=setButtons;
this.checkGuess=checkGuess;
this.submitGuess=submitGuess;
this.printScore=printScore;
this.checkForEndOfGame=checkForEndOfGame;
this.newQuestion=newQuestion;
this.setChoices=setChoices;
this.newAnswer=newAnswer;

}


function resetVariables()
{
        this.question = "";
       	this.count = this.startNumber; 

	this.guess = 0;
        this.answer = 0;
        this.score = 0;
}

function setButtons(offset)
{
	i=1;
	for (i=1; i < this.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}

function checkGuess()
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
function submitGuess(button_id)
{
        this.guess = document.getElementById(button_id).innerHTML;
        this.checkGuess();
}

function printScore()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

function checkForEndOfGame()
{
        if (this.score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

function newQuestion()
{
        //set question
        this.question = this.question + ' ' + this.count;
        document.getElementById("question").innerHTML=this.question;
}

function setChoices()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(offset);
}

function newAnswer()
{
        this.answer = this.count + this.countBy;
}
</script>
