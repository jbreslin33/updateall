<?php
echo "<p1>STATS:<p1>";
echo "<br>";
echo "<br>";
echo "school_name: ";
echo $_SESSION["school_name"];
echo "<br>";
echo "id: ";
echo $_SESSION["id"];
echo "<br>";
echo "username: ";
echo $_SESSION["username"];
echo "<br>";
echo "math_level: ";
echo $_SESSION["math_level"];
echo "<br>";
echo "english_level: ";
echo $_SESSION["english_level"];
echo "<br>";
echo "school_id: ";
echo $_SESSION["school_id"];
echo "<br>";
echo "is_admin: ";
echo $_SESSION["is_admin"];
echo "<br>";
echo "is_teacher: ";
echo $_SESSION["is_teacher"];
echo "<br>";
echo "is_student: ";
echo $_SESSION["is_student"];
echo "<br>";
echo "<br>";
?>

<p1>LINKS:<p1>
<br>
<br>


<p1>MAIN PAGE:<p1>
<br>
<a href="../main/main.php">MAIN PAGE</a>
<br>
<br>


<p1>GAMES:<p1>
<br>
<a href="../subject/chooser.php">Play Game</a>
<br>
<br>


<p1>INSERT:<p1>
<br>

<a href="../insert/student_number.php">INSERT STUDENT WITH NUMBER USERNAME</a>
<br>

<a href="../insert/student_word.php">INSERT STUDENT WITH WORD USERNAME</a>
<br>

<a href="../insert/teacher.php">INSERT TEACHER</a>
<br>

<a href="../insert/class_size.php">INSERT CLASS</a>
<br>

<a href="../insert/homeroom_size.php">INSERT HOMEROOM</a>
<br>

<a href="../insert/school_size.php">INSERT SCHOOL</a>
<br>
<br>


<p1>SELECT:<p1>
<br>

<a href="../select/student.php">SELECT STUDENT</a>
<br>

<a href="../select/teacher.php">SELECT TEACHER</a>
<br>

<a href="../select/class.php">SELECT CLASS</a>
<br>

<a href="../select/homeroom.php">SELECT HOMEROOM</a>
<br>

<a href="../select/school.php">SELECT SCHOOL</a>
<br>
<br>

