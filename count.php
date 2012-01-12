<?php
	start_session();

        // If the user is not logged in send him/her to the login form
        if ($_SESSION["Login"] != "YES")
	{
        	header("Location: login_form.php");
        }
?>

<?php

       	//db connection
        $db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

	//query string - get the row for the game to be played on this page
        $query = "select * ";
        $query .= "from math_games ";
        $query .= "where level = ";
        $query .= $_SESSION["math_game_level"];
        $query .= ";";

	//get db restult
        $dbResult = pg_query($query);

        //check for db error
        if (!$dbResult)
        {
                die("Database error...");
        }

	//get user id and store it in session var
        $name = pg_Result ($dbResult, 0, 'name');
        $start_number = pg_Result ($dbResult, 0, 'start_number');
        $end_number = pg_Result ($dbResult, 0, 'end_number');
?>


<html>
<head>
<script type="text/javascript">

<?php
echo "var count = $start_number; "; 
echo "var endNumber = $end_number; ";
?>

var correctAnswer = 1;
var answer = 0;

function submitAnswer(a)
{
	if (a == 1)
  	{
    		answer = document.getElementById("button1").innerHTML;
  	}
  	else if (a == 2)
  	{
    		answer = document.getElementById("button2").innerHTML;
  	}

  	else if (a == 3)
  	{
    		answer = document.getElementById("button3").innerHTML;
  	}
  	else if (a == 4)
  	{
    		answer = document.getElementById("button4").innerHTML;
  	}
 	checkAnswer();
}

function checkAnswer()
{
  	if (answer == correctAnswer)
  	{
     		document.getElementById("feedback").innerHTML="correct";
     		count++;
     		correctAnswer++;
		var offset = Math.floor(Math.random() *2);
		offset = count - offset;
     
		document.getElementById("counter").innerHTML=count;
     		document.getElementById("button1").innerHTML=offset;
     		document.getElementById("button2").innerHTML=offset + 1;
     		document.getElementById("button3").innerHTML=offset + 2;
     		document.getElementById("button4").innerHTML=offset + 3;

		if (count == endNumber)
		{
     			document.getElementById("feedback").innerHTML="YOU WIN!!!";
		}
  	}
  	else
  	{
		document.getElementById("feedback").innerHTML="wrong";
		count = 0;
		correctAnswer = 1;
		document.getElementById("counter").innerHTML=count;
     		document.getElementById("button1").innerHTML=count;
     		document.getElementById("button2").innerHTML=count + 1;
     		document.getElementById("button3").innerHTML=count + 2;
     		document.getElementById("button4").innerHTML=count + 3;
	}
}
</script>

</head>
<body>
<h1 = id="header1"> 
<?php
echo "$name"; 
?>
 </h1>

<p id="counter">0</p>

<button type="button" id="button1" onclick="submitAnswer(1)">1</button>

<button type="button" id="button2" onclick="submitAnswer(2)">2</button>
<button type="button" id="button3" onclick="submitAnswer(3)">3</button>
<button type="button" id="button4" onclick="submitAnswer(4)">4</button>
<p id="feedback"></p>
</body>
</html> 
