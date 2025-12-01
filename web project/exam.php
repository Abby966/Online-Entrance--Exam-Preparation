<?php
// exam.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Exam Year</title>
</head>
<body>
<h2>Select Exam Year</h2>

<form action="stream.php" method="GET">
    <label>Select Year:</label>
    <select name="year" required>
        <?php
        for ($y = 2014; $y <= 2024; $y++) {
            echo "<option value='$y'>$y Exam</option>";
        }
        ?>
    </select>
    <button type="submit">Next</button>
</form>

</body>
</html>
