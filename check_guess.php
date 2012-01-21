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
        question = "";
       	count = agame.startNumber; 

	guess = 0;
        answer = 0;
        score = 0;
}

function setButtons(offset)
{
	i=1;
	for (i=1; i < agame.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}

function checkGuess()
{
        if (guess == answer)
        {
                count = count + agame.countBy;  //add to count
                score++;

                document.getElementById("feedback").innerHTML="Correct!";

                checkForEndOfGame();
        }
        else
        {
                document.getElementById("feedback").innerHTML="Wrong! Try again.";

                resetVariables();
        }

        printScore();

        newQuestion();
        newAnswer();
        setChoices();
}
function submitGuess(button_id)
{
        guess = document.getElementById(button_id).innerHTML;
        checkGuess();
}

function printScore()
{
        document.getElementById("score").innerHTML="Score: " + score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + agame.scoreNeeded;
}

function checkForEndOfGame()
{
        if (score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

function newQuestion()
{
        //set question
        question = question + ' ' + count;
        document.getElementById("question").innerHTML=question;
}

function setChoices()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = answer - offset;
        setButtons(offset);
}

function newAnswer()
{
        answer = count + agame.countBy;
}
</script>
