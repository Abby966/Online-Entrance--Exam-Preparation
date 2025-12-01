<?php
include "db.php";

$year = $_GET['year'];
$stream = $_GET['stream'];
$subject = $_GET['subject'];

$sql = "SELECT * FROM entrance_questions 
        WHERE year='$year' AND stream='$stream' AND subject='$subject'";
$questions = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $subject; ?> Questions</title>

<style>
#timer {
    font-size: 22px;
    font-weight: bold;
    color: green;
}
</style>

<script>
// --------- COUNT-UP TIMER (Stopwatch) ---------
let seconds = 0;

setInterval(() => {
    seconds++;

    let min = Math.floor(seconds / 60);
    let sec = seconds % 60;

    document.getElementById("timer").innerHTML =
        (min < 10 ? "0"+min : min) + ":" + (sec < 10 ? "0"+sec : sec);

    document.getElementById("time_taken").value = seconds;
}, 1000);
</script>

</head>
<body>

<h2><?php echo $subject; ?> – <?php echo $year; ?></h2>
<h3>Time Taken: <span id="timer">00:00</span></h3>

<form id="quizForm" action="result.php" method="POST">

<input type="hidden" name="year" value="<?php echo $year; ?>">
<input type="hidden" name="stream" value="<?php echo $stream; ?>">
<input type="hidden" name="subject" value="<?php echo $subject; ?>">
<input type="hidden" name="time_taken" id="time_taken" value="0">

<?php
$qnum = 1;
while ($q = $questions->fetch_assoc()):
?>

<p><b><?php echo $qnum . ". " . $q['question']; ?></b></p>

<label><input type="radio" name="q<?php echo $q['id']; ?>" value="1"> <?php echo $q['choice1']; ?></label><br>
<label><input type="radio" name="q<?php echo $q['id']; ?>" value="2"> <?php echo $q['choice2']; ?></label><br>
<label><input type="radio" name="q<?php echo $q['id']; ?>" value="3"> <?php echo $q['choice3']; ?></label><br>
<label><input type="radio" name="q<?php echo $q['id']; ?>" value="4"> <?php echo $q['choice4']; ?></label><br><br>

<?php
$qnum++;
endwhile;
?>

<button type="submit">Submit Exam</button>

</form>

</body>
</html>
