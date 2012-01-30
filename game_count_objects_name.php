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
        this.question = Math.floor(Math.random() *4);
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
	document.getElementById("button1").innerHTML="Zero";
	document.getElementById("button1").value="0";
	
	document.getElementById("button2").innerHTML="One";
	document.getElementById("button2").value="1";
	
	document.getElementById("button3").innerHTML="Two";
	document.getElementById("button3").value="2";
	
	document.getElementById("button4").innerHTML="Three";
	document.getElementById("button4").value="3";
	
	document.getElementById("button5").innerHTML="Four";
	document.getElementById("button5").value="4";
	
	document.getElementById("button6").innerHTML="Five";
	document.getElementById("button6").value="5";
	

document.getElementById("button7").innerHTML="Six";
	document.getElementById("button8").innerHTML="Seven";
	document.getElementById("button9").innerHTML="Eight";
	document.getElementById("button10").innerHTML="Nine";
	document.getElementById("button11").innerHTML="Ten";
	document.getElementById("button12").innerHTML="Eleven";
	document.getElementById("button13").innerHTML="Twelve";
	document.getElementById("button14").innerHTML="Thirteen";
	document.getElementById("button15").innerHTML="Fourteen";
	document.getElementById("button16").innerHTML="Fifteen";
	document.getElementById("button17").innerHTML="Sixteen";
	document.getElementById("button18").innerHTML="Seventeen";
	document.getElementById("button19").innerHTML="Eighteen";
	document.getElementById("button20").innerHTML="Nineteen";
	document.getElementById("button21").innerHTML="Twenty";
}

//submit guess
Game.prototype.submitGuess = function(button_id)
{
	//this.guess = document.getElementById(button_id).innerHTML;
	this.guess = document.getElementById(button_id).value;
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
