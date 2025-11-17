<?php
include 'db.php';
$message = '';

// Handle form submission
if (isset($_POST['submit'])) {
    $course_id = $_POST['course_id'];
    $topic_id = $_POST['course_titles_id']; 
    $question = $_POST['question_text'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $correct = $_POST['correct_option'];


    $sql = "INSERT INTO quiz_questions 
        (course_id, topic_id, question_text, option_a, option_b, option_c, option_d, correct_option) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Check if prepare succeeded
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iissssss", $course_id, $topic_id, $question, $a, $b, $c, $d, $correct);

    if ($stmt->execute()) {
        $message = "✅ Question added successfully!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch courses
$courses = $conn->query("SELECT id, name FROM courses");
if (!$courses) die("Error fetching courses: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Question</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(120deg,#f0f4ff,#ffffff);
  padding: 40px;
}
.container {
  max-width: 700px;
  margin: auto;
  background: #fff;
  padding: 30px;
  border-radius: 18px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
h2 { text-align: center; color: #1e3a8a; }
form select, form textarea, form input { width: 100%; padding: 10px; margin: 8px 0; border-radius: 8px; border: 1px solid #cbd5e1; }
button { background-color: #2563eb; color: white; padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; }
button:hover { background-color: #1e40af; }
.message { text-align:center; font-weight:bold; color:green; }
</style>
</head>
<body>
<div class="container">
  <h2>🧠 Add New Question</h2>
  <?php if($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>
  <form method="POST">
    <label for="course">Select Course:</label>
    <select id="course" name="course_id" required>
      <option value="">-- Select Course --</option>
      <?php while($row = $courses->fetch_assoc()): ?>
        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label for="topic">Select Topic:</label>
    <select id="topic" name="course_titles_id" required>
      <option value="">-- Select Topic --</option>
    </select>

    <label>Question:</label>
    <textarea name="question_text" required></textarea>

    <label>Option A:</label>
    <input type="text" name="option_a" required>
    <label>Option B:</label>
    <input type="text" name="option_b" required>
    <label>Option C:</label>
    <input type="text" name="option_c" required>
    <label>Option D:</label>
    <input type="text" name="option_d" required>

    <label>Correct Option:</label>
    <select name="correct_option" required>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
    </select>

    <button type="submit" name="submit">Add Question</button>
  </form>
</div>

<script>
document.getElementById('course').addEventListener('change', function() {
    var courseId = this.value;
    var topicSelect = document.getElementById('topic');
    topicSelect.innerHTML = '<option>Loading...</option>';

    fetch('fetch_topics.php?course_id=' + courseId) // fetch from course_titles table
    .then(response => response.json())
    .then(data => {
        topicSelect.innerHTML = '<option value="">-- Select Topic --</option>';
        data.forEach(topic => {
            var opt = document.createElement('option');
            opt.value = topic.id;
            opt.textContent = topic.title; // use 'title' column from course_titles
            topicSelect.appendChild(opt);
        });
    })
    .catch(err => {
        topicSelect.innerHTML = '<option value="">Error loading topics</option>';
        console.error(err);
    });
});
</script>
</body>
</html>
