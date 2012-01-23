<script type="text/javascript">

// namespace placeholder
KevLinDev = {};

/**
 * A function used to extend one class with another
 * 
 * @param {Object} subClass
 * 		The inheriting class, or subclass
 * @param {Object} baseClass
 * 		The class from which to inherit
 */
KevLinDev.extend = function(subClass, baseClass) {
   function inheritance() {}
   inheritance.prototype = baseClass.prototype;

   subClass.prototype = new inheritance();
   subClass.prototype.constructor = subClass;
   subClass.baseConstructor = baseClass;
   subClass.superClass = baseClass.prototype;
}


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

}

game.prototype.printScore = function()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

game.prototype.checkForEndOfGame = function()
{
        if (this.score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

game.prototype.resetVariables = function()
{
        this.question = "";
       	this.count = this.startNumber; 

	this.guess = 0;
        this.answer = 0;
        this.score = 0;
}

game.prototype.checkGuess = function()
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


</script>
