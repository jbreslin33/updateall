<html>
<head>
<title>Image Mover</title>
<style>
DIV.movable { position:absolute; }
</style>
<script language="javascript">
var x = 5; //Starting Location - left
var y = 5; //Starting Location - top
var dest_x = 300;  //Ending Location - left
var dest_y = 300;  //Ending Location - top
var interval = 1; //Move 10px every initialization

function moveBot(bot) {
	//Keep on moving the image till the target is achieved
	if(x<dest_x) x = x + interval; 
	if(y<dest_y) y = y + interval;
	
	//Move the image to the new location
	bot.style.top  = y+'px';
	bot.style.left = x+'px';

}
function update()
{
	moveBot(document.getElementById("ufo"));
	
	window.setTimeout('update()',16);

}
</script>
</head>
<body onload="update()">
<div id="ufo" class="movable">
<img src="redball.gif" alt="Please link to a vaild image." />
</div>

</body>
</html>
