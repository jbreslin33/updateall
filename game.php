<script type="text/javascript">

function Game(startNumber,scoreNeeded,countBy,numberOfButtons)
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

Game.prototype.createButtons = function()
{
	var buttonnode= document.createElement('input');
	buttonnode.setAttribute('type','button');
	buttonnode.setAttribute('name','sal');
	buttonnode.setAttribute('value','sal');

	document.getElementById("buttoncontent").appendChild(buttonnode);
	//New Part here
	//buttonnode.onClick = Hi;
}

Game.prototype.printScore = function()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

Game.prototype.checkForEndOfGame = function()
{
        if (this.score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

Game.prototype.resetVariables = function()
{
        this.question = "";
       	this.count = this.startNumber; 

	this.guess = 0;
        this.answer = 0;
        this.score = 0;
}

Game.prototype.checkGuess = function()
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
Game.prototype.newQuestion = function()
{
        //set question
       	//this.question = this.question + ' ' + this.count;
        //document.getElementById("question").innerHTML=this.question;
}

Game.prototype.setChoices = function()
{
        //set buttons
        //var offset = Math.floor(Math.random() *4);
        //offset = this.answer - offset;
        //this.setButtons(offset);
}

Game.prototype.newAnswer = function()
{
        //this.answer = this.count + this.countBy;
}

Game.prototype.setButtons = function(offset)
{
        //i=1;
        //for (i=1; i < this.numberOfButtons + 1; i++)
        //{
        //        j = i - 1;
        //        document.getElementById("button" + i).innerHTML=offset + j;
        //}
}

Game.prototype.submitGuess = function(button_id)
{
        //this.guess = document.getElementById(button_id).innerHTML;

        //this.checkGuess();
        //this.printScore();
        //this.newQuestion();
        //this.newAnswer();
        //this.setChoices();
}

</script>
