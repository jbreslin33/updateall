<html>
<body>

<?php include("check_login.php"); ?>
<?php include("db_connect.php"); ?>

<?php

//db connection
$conn = dbConnect();

//query
$query = "select name, start_number, end_number from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$start_number = 0;
$end_number = 0; 

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//get row
        $row = pg_fetch_row($result);
       	
	//fill php vars from db 
	$name = $row[0];
	$start_number = $row[1];
	$end_number = $row[2];
}

echo "<script type=\"text/javascript\">";

//set javascript vars from db result set
echo "var count = $start_number; ";
echo "var endNumber = $end_number; ";

$correctAnswer = $start_number + 1;
echo "var correctAnswer = $correctAnswer;"

?>

var answer = 0;
var question_string = count;

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
		
		question_string = question_string + ' ' + count;
	
		document.getElementById("question").innerHTML=question_string;
		
		setButtons(offset);
                	
		if (count == endNumber)
                {
                        document.getElementById("feedback").innerHTML="YOU WIN!!!";
			window.location = "goto_next_math_level.php"					
                }
        }
        else
        {
                document.getElementById("feedback").innerHTML="wrong";
		<?php 
		echo "count = $start_number;";                
                
		$correctAnswer = $start_number + 1;
		echo "correctAnswer = $correctAnswer;";
		?>	
                
		document.getElementById("question").innerHTML=count;
		question_string = count;	
       
		setButtons(count);         
        }
}

function setButtons(offset)
{
	document.getElementById("button1").innerHTML=offset;
        document.getElementById("button2").innerHTML=offset + 1;
	document.getElementById("button3").innerHTML=offset + 2;
        document.getElementById("button4").innerHTML=offset + 3;
}

</script>

<!-- Game Name -->
<h1 = id="game_name">
<?php
echo "$name";
?>
</h1>

<!-- question --> 

<p id="question"> <?php echo "$start_number"; ?>  </p>

<!-- Create Buttons (could this be done in db?) -->
<?php
$b1 = $start_number + 1;
$b2 = $start_number + 2;
$b3 = $start_number + 3;
$b4 = $start_number + 4;
?>

<button type="button" id="button1" onclick="submitAnswer(1)"> <?php echo "$b1"; ?> </button>
<button type="button" id="button2" onclick="submitAnswer(2)"> <?php echo "$b2"; ?> </button>
<button type="button" id="button3" onclick="submitAnswer(3)"> <?php echo "$b3"; ?> </button>
<button type="button" id="button4" onclick="submitAnswer(4)"> <?php echo "$b4"; ?> </button>

<!-- Feedback -->
<p id="feedback"></p>

</body>
</html> 
