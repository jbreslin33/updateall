<html>
<body>

<input type="text" id="clock" />
<script language=javascript>
DIV.movable { position:absolute; }
</style>
<div id="ufo" class="movable"><img src="images/ufo.gif" /></div>

var int=self.setInterval("clock()",1000);
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
