<script type="text/javascript">

function GameCountObjectNumber(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	
	GameCountObjectNumber.baseConstructor.call(this,startNumber,scoreNeeded,countBy,numberOfButtons);
}

// subclass 
KInherit.extend(GameCountObjectNumber, GameCountWrite);

GameCountObjectNumber.prototype.createImages = function()
{
	var img = new Image();   // Create new img element  
	img.src = 'redball.gif'; // Set source path	
	img.id = 'image1';	
	document.getElementById("image_div").appendChild(img);	
	if (document.getElementById("image_div").hasChildNodes())
	{
		alert("child nodes");
	}
	else
	{
		alert("no child nodes");
	}
}

</script>
