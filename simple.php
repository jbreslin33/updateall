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


function game()
{

}

function update() {
	//Keep on moving the image till the target is achieved
	x = x + interval; 
	y = y + interval;
	
	//Move the image to the new location
	document.getElementById("ufo").style.top  = y+'px';
	document.getElementById("ufo").style.left = x+'px';

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
