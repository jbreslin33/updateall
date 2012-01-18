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

