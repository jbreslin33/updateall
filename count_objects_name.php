<?php

include("top.php");
include("middle.php");

?>

<!-- class for game -->
<?php include("game_count_objects_name.php"); ?>

<!-- creating game --> 
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<!-- lower.php -->
<?php include("lower.php"); ?>
