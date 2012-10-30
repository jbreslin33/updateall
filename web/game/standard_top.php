
<script language="javascript">
var curDate = "<?php echo $curDate; ?>";
var username = "<?php echo $username; ?>";
var next_level = "<?php echo $next_level; ?>";

</script>
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

