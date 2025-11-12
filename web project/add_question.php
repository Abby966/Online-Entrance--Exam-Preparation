<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "intrance_prep_app";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = trim($_POST['course']);
    $question_text = trim($_POST['question_text']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $correct_option = strtoupper(trim($_POST['correct_option']));

    // Simple validation
    if (!$course || !$question_text || !$option_a || !$option_b || !$option_c || !$option_d || !in_array($correct_option, ['A','B','C','D'])) {
        $message = "Please fill all fields correctly!";
    } else {
        $stmt = $conn->prepare("INSERT INTO questions (course, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssssss", $course, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);
            if ($stmt->execute()) {
                $message = "Question added successfully!";
            } else {
                $message = "Error adding question: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Prepare failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Quiz Question</title>
<style>
body { font-family: Arial; max-width: 600px; margin: 50px auto; }
input, textarea, select { width: 100%; margin-bottom: 10px; padding: 8px; }
button { padding: 10px 20px; }
.message { margin-bottom: 15px; font-weight: bold; }
</style>
</head>
<body>

<h2>Add a Quiz Question</h2>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" action="">
    <label>Course:</label>
    <select name="course">
        <option value="Mathematics">Mathematics</option>
        <option value="Physics">Physics</option>
        <option value="Chemistry">Chemistry</option>
        <option value="Biology">Biology</option>
        <option value="Computer Science">Computer Science</option>
    </select>

    <label>Question Text:</label>
    <textarea name="question_text" rows="3" required></textarea>

    <label>Option A:</label>
    <input type="text" name="option_a" required>

    <label>Option B:</label>
    <input type="text" name="option_b" required>

    <label>Option C:</label>
    <input type="text" name="option_c" required>

    <label>Option D:</label>
    <input type="text" name="option_d" required>

    <label>Correct Option (A, B, C, D):</label>
    <input type="text" name="correct_option" maxlength="1" required>

    <button type="submit">Add Question</button>
</form>

</body>
</html>
