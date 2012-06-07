<html>
<body>

<style>

DIV.movable { position:absolute; }

</style>

<input type="text" id="clock" />

<div id="ufo" class="movable"><img src="wizard_north.png" /></div>

<script language=javascript>

var int=self.setInterval("clock()",1000);

document.getElementById("ufo").style.top  = '200px';
document.getElementById("ufo").style.left = '0px';

function clock()
{
	var d=new Date();
  	var t=d.toLocaleTimeString();
  	document.getElementById("clock").value=t;
}



</script>

<button onclick="int=window.clearInterval(int)">Stop</button>

</body>
</html> 
