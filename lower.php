<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question -->
<p id="question"> </p>

<div id="buttoncontent"> </div>

<!-- Create Buttons (could this be done in db?) -->
<?php

$i=1;
for ($i=1; $i < $numberOfButtons + 1; $i++)
{
        echo "<button type=\"button\" id=\"button$i\" onclick=\"game.submitGuess(this.id)\"> </button> ";
}

?>

<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<script type="text/javascript"> game.init(); </script>

</body>
</html>

