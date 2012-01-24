<script type="text/javascript">

function GameCountWrite(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	
	GameCountWrite.baseConstructor.call(this,startNumber,scoreNeeded,countBy,numberOfButtons);
	this.answers = new Array();
	this.answers[0] = "0";
	this.answers[1] = "1";
	this.answers[2] = "2";
	this.answers[3] = "3";
	this.answers[4] = "4";
	this.answers[5] = "5";
	this.answers[6] = "6";
	this.answers[7] = "7";
	this.answers[8] = "8";
	this.answers[9] = "9";
	this.answers[10] = "1";
	this.answers[11] = "0";
	this.answers[12] = "1";
	this.answers[13] = "1";
	this.answers[14] = "1";
	this.answers[15] = "2";
	this.answers[16] = "1";
	this.answers[17] = "3";
	this.answers[18] = "1";
	this.answers[19] = "4";
	this.answers[20] = "1";
	this.answers[21] = "5";
	this.answers[22] = "1";
	this.answers[23] = "6";
	this.answers[24] = "1";
	this.answers[25] = "7";
	this.answers[26] = "1";
	this.answers[27] = "8";
	this.answers[28] = "1";
	this.answers[29] = "9";
	this.answers[30] = "2";
	this.answers[31] = "0";
}

// subclass 
KInherit.extend(GameCountWrite,Game);


//overide
GameCountWrite.prototype.newQuestion = function()
{
        
	//set question

        if (this.count < 10 || this.count == 10 || this.count == 12 || this.count == 14 || this.count == 16 || this.count == 18 || this.count == 20
         || this.count == 22 || this.count == 24 || this.count == 26 || this.count == 28 || this.count == 30)
        {
                this.question = this.question + ' ' +  this.answers[this.count];
        }
        else
        {
                this.question = this.question + '' +  this.answers[this.count];
        }
        document.getElementById("question").innerHTML=this.question;
}

GameCountWrite.prototype.setChoices = function()
{
 	//set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(0);
}

GameCountWrite.prototype.newAnswer = function()
{
   this.answer = this.answers[this.count + this.countBy];

}

GameCountWrite.prototype.setButtons = function(offset)
{
	i=1;
	for (i=1; i < this.numberOfButtons + 1; i++)
	{
		j = i - 1;
		document.getElementById("button" + i).innerHTML=offset + j;
	}
}

GameCountWrite.prototype.submitGuess = function(button_id)
{
	this.guess = document.getElementById(button_id).innerHTML;
        this.checkGuess();
        this.printScore();
        this.newQuestion();
        this.newAnswer();
        this.setChoices();
}


</script>
