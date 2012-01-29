<script type="text/javascript">

function Game(startNumber,scoreNeeded,countBy,numberOfButtons)
{

//vars
this.score=0;
this.scoreNeeded = scoreNeeded;

//game
this.numberOfButtons = numberOfButtons;
this.question="";
this.guess=0;
this.answer=0;

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
//	alert("reset");
        this.question = "";
       	this.count = this.startNumber; 

	this.guess = 0;
        this.answer = 0;
        this.score = 0;
}


</script>
