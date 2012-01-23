<script type="text/javascript">

function gameCount(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	gameCount.baseConstructor.call(this,startNumber,scoreNeeded,countBy,numberOfButtons);

}

// subclass Person
//KevLinDev.extend(Employee, Person);
KevLinDev.extend(gameCount,game);


//overide
gameCount.prototype.newQuestion = function()
{
        //set question
        this.question = this.question + ' ' + this.count;
        document.getElementById("question").innerHTML=this.question;
}

gameCount.prototype.setChoices = function()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(offset);
}

gameCount.prototype.newAnswer = function()
{
        this.answer = this.count + this.countBy;
}

gameCount.prototype.setButtons = function(offset)
{
	i=1;
	for (i=1; i < this.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}

gameCount.prototype.submitGuess = function(button_id)
{
        this.guess = document.getElementById(button_id).innerHTML;
        
	this.checkGuess();
        this.printScore();
        this.newQuestion();
        this.newAnswer();
        this.setChoices();
}


</script>
