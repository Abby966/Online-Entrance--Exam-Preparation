<?php
include "db.php";

$year = $_POST['year'];
$stream = $_POST['stream'];
$subject = $_POST['subject'];

$sql = "SELECT * FROM entrance_questions 
        WHERE year='$year' AND stream='$stream' AND subject='$subject'";
$questions = $conn->query($sql);

$score = 0;
$total = $questions->num_rows;

while ($q = $questions->fetch_assoc()) {
    $qid = "q" . $q['id'];
    if (isset($_POST[$qid]) && $_POST[$qid] == $q['correct_answer']) {
        $score++;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Result</title></head>
<body>

<h2>Result – <?php echo $subject; ?> (<?php echo $year; ?>)</h2>
<h3>You scored: <?php echo $score; ?> / <?php echo $total; ?></h3>

<a href="exam.php"><button>Take Another Exam</button></a>

</body>
</html>
