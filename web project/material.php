<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "intrance_prep_app";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$courseSlug = $_GET['course'] ?? '';
$title      = $_GET['title'] ?? '';

$courseName = ucwords(str_replace('-', ' ', $courseSlug));

$stmt = $conn->prepare("SELECT id FROM courses WHERE name = ?");
$stmt->bind_param("s", $courseName);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Course not found.");
}
$courseId = $result->fetch_assoc()['id'];

$stmt = $conn->prepare("SELECT id FROM course_titles WHERE course_id = ? AND title = ?");
$stmt->bind_param("is", $courseId, $title);
$stmt->execute();
$titleResult = $stmt->get_result();
if ($titleResult->num_rows === 0) {
    die("Topic not found.");
}
$titleId = $titleResult->fetch_assoc()['id'];

$stmt = $conn->prepare("SELECT pdf_url FROM materials WHERE title_id = ?");
$stmt->bind_param("i", $titleId);
$stmt->execute();
$pdfResult = $stmt->get_result();
if ($pdfResult->num_rows === 0) {
    die("No material found for this topic.");
}
$pdfPath = $pdfResult->fetch_assoc()['pdf_url'];

if (!file_exists($pdfPath)) {
    die("PDF file not found on server.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($title); ?> - PDF Material</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6f9;
    }
    header {
      background: #1d2b64;
      color: white;
      padding: 16px 24px;
      font-size: 20px;
      font-weight: bold;
    }
    .pdf-container {
      width: 100%;
      height: calc(100vh - 64px);
    }
    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>
</head>
<body>
  <header>
    <?php echo htmlspecialchars($courseName . " - " . $title); ?>
  </header>
  <div class="pdf-container">
    <iframe src="<?php echo htmlspecialchars($pdfPath); ?>"></iframe>
  </div>
</body>
</html>
