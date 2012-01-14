<html>
<body>

<?php include("check_login.php"); ?>

<?php

//grab session variable math_game_level that was stored when we queried users table in login.php
$math_game_level = $_SESSION["math_game_level"];

//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") 
or die('Could not connect: ' . pg_last_error());

//query
$query = "select name, start_number, end_number ";
$query .= "from math_games ";
$query .= "where level = ";
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
        $row = pg_fetch_row($result);
        $name = $row[0];
	$start_number = $row[1];
	$end_number = $row[2];
}

echo "<script type=\"text/javascript\">";

//set javascript vars from db result set
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

                document.getElementById("question").innerHTML=count;
		
		setButton(offset);
                	
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
                document.getElementById("question").innerHTML=count;
       
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
<p id="question">0</p>

<!-- Create Buttons (could this be done in db?) -->
<button type="button" id="button1" onclick="submitAnswer(1)">1</button>
<button type="button" id="button2" onclick="submitAnswer(2)">2</button>
<button type="button" id="button3" onclick="submitAnswer(3)">3</button>
<button type="button" id="button4" onclick="submitAnswer(4)">4</button>

<!-- Feedback -->
<p id="feedback"></p>

</body>
</html> 
