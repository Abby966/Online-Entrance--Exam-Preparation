<?php
session_start();

// --- DATABASE CONNECTION ---
$host = "localhost";
$user = "root";
$password = "";
$dbname = "intrance_prep_app";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

$message = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $fileName = $_FILES['csv_file']['tmp_name'];
    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($fileName, "r");
        $rowCount = 0;
        $errorCount = 0;

        // Skip header row
        fgetcsv($file);

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            if (count($column) >= 7) {
                list($course, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option) = $column;
                $course = trim($course);
                $question_text = trim($question_text);
                $option_a = trim($option_a);
                $option_b = trim($option_b);
                $option_c = trim($option_c);
                $option_d = trim($option_d);
                $correct_option = strtoupper(trim($correct_option));

                if (in_array($correct_option, ['A','B','C','D'])) {
                    $stmt = $conn->prepare("INSERT INTO questions (course, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $course, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);
                    if ($stmt->execute()) {
                        $rowCount++;
                    } else {
                        $errorCount++;
                    }
                    $stmt->close();
                } else {
                    $errorCount++;
                }
            } else {
                $errorCount++;
            }
        }

        fclose($file);
        $message = "✅ Successfully added $rowCount questions. ⚠️ $errorCount failed.";
        $type = "success";
    } else {
        $message = "⚠️ Please upload a valid CSV file.";
        $type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>📚 Bulk Upload Questions</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #e0e7ff, #f9fafb);
  margin: 0;
  padding: 0;
}
.container {
  max-width: 600px;
  margin: 80px auto;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 22px rgba(0,0,0,0.1);
  padding: 40px;
  text-align: center;
}
h2 {
  color: #1e40af;
}
input[type=file] {
  margin: 20px 0;
  border: 2px dashed #93c5fd;
  padding: 20px;
  border-radius: 10px;
  background: #f0f9ff;
  cursor: pointer;
}
button {
  background: #2563eb;
  color: #fff;
  padding: 12px 24px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: 0.3s;
}
button:hover {
  background: #1d4ed8;
}
.alert {
  padding: 12px;
  border-radius: 8px;
  margin-bottom: 15px;
  font-weight: bold;
}
.alert.success {
  background: #dcfce7;
  color: #166534;
}
.alert.error {
  background: #fee2e2;
  color: #991b1b;
}
footer {
  margin-top: 30px;
  color: #6b7280;
  font-size: 13px;
}
.sample {
  background: #f3f4f6;
  border-radius: 8px;
  padding: 15px;
  margin-top: 20px;
  text-align: left;
  font-size: 14px;
}
</style>
</head>

<body>
<div class="container">
  <h2>📚 Bulk Upload Quiz Questions</h2>

  <?php if ($message): ?>
      <div class="alert <?= $type ?>"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
      <input type="file" name="csv_file" accept=".csv" required>
      <button type="submit">🚀 Upload Questions</button>
  </form>

  <div class="sample">
    <strong>📄 CSV Format Example:</strong><br><br>
    <code>
    Course,Question Text,Option A,Option B,Option C,Option D,Correct Option<br>
    Physics,What is the speed of light?,3x10^8 m/s,5x10^6 m/s,7x10^3 m/s,1x10^5 m/s,A<br>
    Biology,Which organ produces insulin?,Liver,Pancreas,Heart,Lungs,B
    </code>
  </div>

  <footer>© 2025 EntrancePrep | Bulk Upload Engine 💾</footer>
</div>
</body>
</html>
