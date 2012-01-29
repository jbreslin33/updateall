<script type="text/javascript">

function GameCountObjectNumber(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	
	GameCountObjectNumber.baseConstructor.call(this,startNumber,scoreNeeded,countBy,numberOfButtons);
}

// subclass 
KInherit.extend(GameCountObjectNumber, GameCountWrite);

//over rides
GameCountObjectNumber.prototype.newQuestion = function()
{

        //set question
	this.question = Math.floor(Math.random() *10);
	this.question++;
	
	
	this.removeImages();
	this.createImages();	
}

//new functions
GameCountObjectNumber.prototype.createImages = function()
{
	var i = 0;	
	for (i=0; i < this.question; i++)
	{
		var img = new Image();   // Create new img element  
		img.src = 'redball.gif'; // Set source path	
		document.getElementById("image_div").appendChild(img);	
	}
}


GameCountObjectNumber.prototype.removeImages = function()
{
	while (document.getElementById("image_div").hasChildNodes()) 	
	{
		document.getElementById("image_div").removeChild(document.getElementById("image_div").firstChild);	
	}
}
</script>
