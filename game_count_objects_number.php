<script type="text/javascript">

function GameCountObjectNumber(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	
	GameCountObjectNumber.baseConstructor.call(this,startNumber,scoreNeeded,countBy,numberOfButtons);
}

// subclass 
KInherit.extend(GameCountObjectNumber, GameCountWrite);

GameCountObjectNumber.prototype.createImages = function()
{
	


}

</script>
