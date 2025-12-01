<?php
$year = $_GET['year'];
$stream = $_GET['stream'];

$natural = ["Biology","Chemistry","Physics","English","Mathematics","SAT"];
$social = ["English","Mathematics","Geography","History","Economics","Civics"];

$subjects = ($stream == "natural") ? $natural : $social;
?>
<!DOCTYPE html>
<html>
<head><title>Subjects</title></head>
<body>

<h2><?php echo ucfirst($stream); ?> Subjects – <?php echo $year; ?> Exam</h2>

<ul>
<?php foreach ($subjects as $sub): ?>
    <li>
        <a href="questions.php?year=<?php echo $year; ?>&stream=<?php echo $stream; ?>&subject=<?php echo $sub; ?>">
            <?php echo $sub; ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>

</body>
</html>
