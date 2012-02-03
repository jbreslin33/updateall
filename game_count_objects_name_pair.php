<script type="text/javascript" src="jquery.js"></script>

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
        this.question = Math.floor(Math.random() *21);
        //this.question++;
       
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
	document.getElementById("button1").innerHTML="ZeroDog";
	document.getElementById("button1").value="0";
	
	document.getElementById("button2").innerHTML="OneDog";
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
	document.getElementById("button7").value="6";
	
	document.getElementById("button8").innerHTML="Seven";
	document.getElementById("button8").value="7";
	
	document.getElementById("button9").innerHTML="Eight";
	document.getElementById("button9").value="8";
	
	document.getElementById("button10").innerHTML="Nine";
	document.getElementById("button10").value="9";
	
	document.getElementById("button11").innerHTML="Ten";
	document.getElementById("button11").value="10";
	
	document.getElementById("button12").innerHTML="Eleven";
	document.getElementById("button12").value="11";
	
	document.getElementById("button13").innerHTML="Twelve";
	document.getElementById("button13").value="12";
	
	document.getElementById("button14").innerHTML="Thirteen";
	document.getElementById("button14").value="13";
	
	document.getElementById("button15").innerHTML="Fourteen";
	document.getElementById("button15").value="14";
	
	document.getElementById("button16").innerHTML="Fifteen";
	document.getElementById("button16").value="15";
	
	document.getElementById("button17").innerHTML="Sixteen";
	document.getElementById("button17").value="16";
	
	document.getElementById("button18").innerHTML="Seventeen";
	document.getElementById("button18").value="17";
	
	document.getElementById("button19").innerHTML="Eighteen";
	document.getElementById("button19").value="18";
	
	document.getElementById("button20").innerHTML="Nineteen";
	document.getElementById("button20").value="19";
	
	document.getElementById("button21").innerHTML="Twenty";
	document.getElementById("button21").value="20";
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
