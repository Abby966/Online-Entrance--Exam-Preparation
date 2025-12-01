<?php
$year = $_GET['year'] ?? null;

if (!$year) {
    header("Location: exam.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Select Stream</title></head>
<body>

<h2>Select Stream for <?php echo $year; ?> Exam</h2>

<a href="subjects.php?year=<?php echo $year; ?>&stream=natural">
    <button>Natural Science</button>
</a>
<br><br>

<a href="subjects.php?year=<?php echo $year; ?>&stream=social">
    <button>Social Science</button>
</a>

</body>
</html>
