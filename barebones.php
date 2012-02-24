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

function moveImage() {
	//Keep on moving the image till the target is achieved
	if(x<dest_x) x = x + interval; 
	if(y<dest_y) y = y + interval;
	
	//Move the image to the new location
	document.getElementById("ufo").style.top  = y+'px';
	document.getElementById("ufo").style.left = x+'px';

	if ((x+interval < dest_x) && (y+interval < dest_y)) {
		//Keep on calling this function every 100 microsecond 
		//	till the target location is reached
		window.setTimeout('moveImage()',16);
	}
}
</script>
</head>
<body onload="moveImage()">
<div id="ufo" class="movable">
<img src="redball.gif" alt="Please link to a vaild image." />
</div>

</body>
</html>
