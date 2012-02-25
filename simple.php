<html>
<head>
<title>Image Mover</title>
<style>
DIV.movable { position:absolute; }
</style>
<script language="javascript">
var x = 5; //Starting Location - left
var y = 5; //Starting Location - top
var interval = 1; //Move 10px every initialization

function moveBot(bot) {
	//Keep on moving the image till the target is achieved
	x = x + interval; 
	y = y + interval;
	
	//Move the image to the new location
	bot.style.top  = y+'px';
	bot.style.left = x+'px';

}

function update()
{
	moveBot(document.getElementById("avatar_id"));
	
	window.setTimeout('update()',16);

}
</script>
</head>
<body onload="update()">
<div id="avatar_id" class="movable">
<img src="redball.gif" alt="Please link to a vaild image." />
</div>

</body>
</html>
