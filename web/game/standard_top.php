
<?php
include(getenv("DOCUMENT_ROOT") . "/web/login/check_login.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/insert_into_games_attempts.php");

//db connection
$conn = dbConnect();

//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select question, answer, question_order from questions where level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= " ORDER BY question_order;";


//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$username = $_SESSION["username"];
$next_level = $_SESSION["next_level"];

//get numer of rows which will also be score needed
$numberOfRows = pg_num_rows($result);
$scoreNeeded = pg_num_rows($result);

?>


<html>
<head>
<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="/src/mootools/mootools-core-1.4.5-full-compat.js"></script>


<?php

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var scoreNeeded = $numberOfRows;";
echo "var questions = new Array();";
echo "var answers = new Array();";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_row($result))
{
        //fill php vars from db
        $questions = $row[0];
        $answers = $row[1];

        echo "<script language=\"javascript\">";

        echo "questions[$counter] = \"$questions\";";
        echo "answers[$counter] = \"$answers\";";
        echo "</script>";
        $counter++;
}

//brian - get current date
$_SESSION["game_start_time"] = date('Y-m-d H:i:s');
$_SESSION["game_over"] = "false";

//brian - attempt a game - still hardcoding game_id = 1
insertIntoGamesAttempts($conn,$_SESSION["game_start_time"],1,$_SESSION["user_id"],$_SESSION["next_level"]);
?>

<script language="javascript">
var curDate = "<?php echo $curDate; ?>";
var username = "<?php echo $username; ?>";
var next_level = "<?php echo $next_level; ?>";
</script>

<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
<script type="text/javascript" src="/src/shape/shape_player.php"></script>
<script type="text/javascript" src="/src/shape/shape_door.php"></script>
<script type="text/javascript" src="/src/shape/shape_ai.php"></script>
<script type="text/javascript" src="/src/div/div.php"></script>
<script type="text/javascript" src="/src/question/question.php"></script>
<script type="text/javascript" src="/src/quiz/quiz.php"></script>
<script type="text/javascript" src="/src/hud/hud.php"></script>


</head>

<body bgcolor="grey">

<script language="javascript">
var mGame;
var mApplication;

window.addEvent('domready', function()
{
        //APPLICATION
        mApplication = new Application();

        //KEYS
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

        //BOUNDS AND HUD COMBO
        mBounds = new Bounds(60,735,380,35);

        mHud = new Hud();
        mHud.mScoreNeeded.setText('<font size="2"> Needed : ' + scoreNeeded + '</font>');
        mHud.mGameName.setText('<font size="2">DUNGEON</font>');

        //GAME
        mGame = new Game("hardcode");

        //QUIZ
        mQuiz = new Quiz(scoreNeeded);
        mGame.mQuiz = mQuiz;

        //QUESTIONS FOR QUIZ
        for (i = 0; i < scoreNeeded; i++)
        {
                var question = new Question(questions[i],answers[i]);
                mQuiz.mQuestionArray.push(question);
        }




