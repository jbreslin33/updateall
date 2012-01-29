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

	//var objectsToCount = Math.floor(Math.random() *4);		
	this.createImages();	
	
}

//new functions
GameCountObjectNumber.prototype.createImages = function()
{
	
	var offset = Math.floor(Math.random() *10);
	//var i = 0;	
	//for (i=0; i < offset; i++)
	//{
		var img = new Image();   // Create new img element  
		img.src = 'redball.gif'; // Set source path	
		img.id = 'image1';	
		document.getElementById("image_div").appendChild(img);	
}


GameCountObjectNumber.prototype.removeImages = function()
{
	while (document.getElementById("image_div").hasChildNodes()) 	
	{
		alert("children still exist");
	}
	alert("no more children");

}
</script>
