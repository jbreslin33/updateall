<!-- initialize variables for start of new game or reset -->
<script type="text/javascript"> gameCountWrite.resetVariables(); </script>

<!-- newQuestion -->
<script type="text/javascript"> gameCountWrite.newQuestion(); </script>

<!-- newAnswer -->
<script type="text/javascript"> gameCountWrite.newAnswer(); </script>

<!-- call setChoices to initialize their innerhtml -->
<script type="text/javascript"> gameCountWrite.setChoices(); </script>


<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<!-- call printScore -->
<script type="text/javascript"> gameCountWrite.printScore(); </script>

</body>
</html>

