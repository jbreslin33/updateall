<script type="text/javascript">



//set javascript vars from db result set
var question = ""; //use to ask actuall question
var guess = 0; // the users guess to question
var count = 0; //this aids in asking the next question
var answer = 0; //this is the correct answer to use for comparison to guess
var score = 0;
var countBy = 0;
var numberOfButtons = 0;

function resetVariables()
{
        question = "";
        <?php echo "count = $startNumber;"; ?>
        guess = 0;
        answer = 0;
        score = 0;
        <?php echo "scoreNeeded = $scoreNeeded;"; ?>
        <?php echo "countBy = $countBy;"; ?>
        <?php echo "numberOfButtons = $numberOfButtons;"; ?>
}

<!-- set buttons inner html -->
function setButtons(offset)
{
        <?php
        $i=1;
        for ($i=1; $i < $numberOfButtons + 1; $i++)
        {
                $j = $i - 1;
                echo "document.getElementById(\"button$i\").innerHTML=offset + $j;";
        }
        ?>
}


function checkGuess()
{
        if (guess == answer)
        {
                count = count + countBy;  //add to count
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
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + scoreNeeded;
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
        answer = count + countBy;
}
</script>
