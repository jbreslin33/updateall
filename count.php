<html>
<body>

<?php

session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
        header("Location: login_form.php");
}


$math_game_level = $_SESSION["math_game_level"];

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

//get game parameters...
//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") 
or die('Could not connect: ' . pg_last_error());

//query
$query = "select name, start_number, end_number ";
$query .= "from math_games ";
$query .= "where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";


echo "<h1> Query: $query </h1>";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$num = pg_num_rows($result);

echo "<h1>  Number of Rows: $num </h1>";

$name = "";
$start_number = 0;
$end_number = 0; 

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        $row = pg_fetch_row($result);
        $name = $row[0];
	$start_number = $row[1];
	$end_number = $row[2];
}

echo "<h1> name: $name </h1>";
echo "<h1> start_number: $start_number </h1>";
echo "<h1> end_number: $end_number </h1>"; 


echo "<script type=\"text/javascript\">";

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

<h1 = id="header1">
 </h1>

<p id="counter">0</p>

<button type="button" id="button1" onclick="submitAnswer(1)">1</button>

<button type="button" id="button2" onclick="submitAnswer(2)">2</button>
<button type="button" id="button3" onclick="submitAnswer(3)">3</button>
<button type="button" id="button4" onclick="submitAnswer(4)">4</button>
<p id="feedback"></p>




</body>
</html> 
