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
	document.body.appendChild(img)//append to body	

}

</script>
