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
}

//Score
Game.prototype.printScore = function()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

//check for endgame
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
}

Game.prototype.checkGuess = function()
{
        if (this.guess == this.answer)
        {
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

//new question
Game.prototype.newQuestion = function()
{
        //set question
        this.question = Math.floor(Math.random() *10);
        this.question++;
       
	//images 
	this.removeImages();
        this.createImages();
}

//set choices
Game.prototype.setChoices = function()
{
 	//set buttons
        this.setButtons(0);
}

//new answer
Game.prototype.newAnswer = function()
{
	this.answer = this.question;
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

//images
Game.prototype.init = function()
{
        this.resetVariables();
        
        this.newQuestion();
        this.newAnswer();
        this.setChoices();
        this.printScore();
}

//create images
Game.prototype.createImages = function()
{
        var i = 0;
        for (i=0; i < this.question; i++)
        {
                var img = new Image();   // Create new img element
                img.src = 'redball.gif'; // Set source path
                document.getElementById("question").appendChild(img);
        }
}

//remove images
Game.prototype.removeImages = function()
{
        while (document.getElementById("question").hasChildNodes())
        {
                document.getElementById("question").removeChild(document.getElementById("question").firstChild);
        }
}

</script>
