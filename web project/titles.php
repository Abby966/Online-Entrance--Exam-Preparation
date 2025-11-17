<?php
// details.php

// Database connection parameters
$host = "localhost";
$user = "root"; // Update if different
$password = ""; // Update if different
$dbname = "intrance_prep_app"; // Update to your actual database name

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the 'course' parameter from the URL
$courseSlug = $_GET['course'] ?? '';
$type       = $_GET['type']   ?? 'quiz'; // quiz | material

// Convert slug to course name (e.g., 'biology' -> 'Biology')
$courseName = ucwords(str_replace('-', ' ', $courseSlug));

// Fetch course ID
$stmt = $conn->prepare("SELECT id FROM courses WHERE name = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $courseName);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $course = $result->fetch_assoc();
    $courseId = intval($course['id']);

    // Fetch topics for the course
    $stmt = $conn->prepare("SELECT title FROM course_titles WHERE course_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $topicsResult = $stmt->get_result();

    $topics = [];
    if ($topicsResult) {
        while ($row = $topicsResult->fetch_assoc()) {
            $topics[] = $row['title'];
        }
    }
} else {
    die("Course not found.");
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($courseName); ?> Topics</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f6fa;
    }

    header {
      background: rgba(255, 255, 255, 0.95);
      padding: 18px 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo img {
      width: 42px;
      height: 42px;
    }

    .logo span {
      color: #1d2b64;
      font-size: 28px;
      font-weight: 700;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #1d2b64;
      font-weight: 600;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #e94e77;
    }

    .content {
      padding: 50px 20px;
      max-width: 800px;
      margin: auto;
    }

    .content h1 {
      color: #1d2b64;
      font-size: 32px;
      margin-bottom: 20px;
    }

    .topics-list {
      list-style-type: none;
      padding: 0;
    }

   .topics-list li {
  display: flex;
  align-items: center;
  background-color: #ffffff;
  margin-bottom: 12px;
  padding: 16px 20px;
  border-radius: 12px;
  border: 1.5px solid #d6d8e0; /* subtle visible border */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
  border-left: 6px solid #1d2b64;
  transition: all 0.3s ease;
  cursor: pointer;
}

.topics-list li:hover {
  background-color: #f0f4ff;
  border-left-color: #e94e77;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
  transform: translateX(6px);
}

.topics-list li::before {
  content: '📘';
  font-size: 22px;
  margin-right: 12px;
  transition: transform 0.3s ease;
}

.topics-list li:hover::before {
  transform: scale(1.1) rotate(-5deg);
}

  </style>
</head>
<body>

  <header>
    <div class="logo">
      <img src="images/graduation.png" alt="IntrancePrep Logo" />
      <span>IntrancePrep</span>
    </div>
    <nav>
      <a href="main.php">Home</a>
      <a href="account.php">Account</a>
    </nav>
  </header>

  <div class="content">
    <input
  type="text"
  id="searchInput"
  placeholder="Search topics..."
  onkeyup="filterTopics()"
  style="
    width: 60%;
    padding: 12px 16px;
    margin-bottom: 24px;
    border: 1.5px solid #ccc;
    border-radius: 14px;
    font-size: 16px;
  "
/>

    <h1><?php echo htmlspecialchars($courseName); ?> Topics</h1>
    <?php if (!empty($topics)): ?>
      
      <ul class="topics-list">
        <?php foreach ($topics as $topic): ?>
          <li onclick="location.href='<?php echo ($type === 'quiz') ? 'quiz.php' : 'material.php'; ?>?course=<?php echo urlencode($courseSlug); ?>&title=<?php echo urlencode($topic); ?>'">
  <?php echo htmlspecialchars($topic); ?>
</li>

        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No topics available for this course.</p>
    <?php endif; ?>
  </div>
<script>
  function filterTopics() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const listItems = document.querySelectorAll(".topics-list li");

    listItems.forEach(function (item) {
      const text = item.textContent.toLowerCase();
      item.style.display = text.includes(filter) ? "flex" : "none";
    });
  }
</script>

</body>
</html>
