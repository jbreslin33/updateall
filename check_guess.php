<script type="text/javascript">

<?php echo "var agame = new game($startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?>
 

function game(startNumber,scoreNeeded,countBy,numberOfButtons)
{

this.startNumber = startNumber;
this.scoreNeeded = scoreNeeded;
this.countBy = countBy;
this.numberOfButtons = numberOfButtons;

}


//set javascript vars from db result set
var question = ""; //use to ask actuall question
var guess = 0; // the users guess to question
var count = 0; //this aids in asking the next question
var answer = 0; //this is the correct answer to use for comparison to guess
var score = 0;

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
