<?php
session_start();
$host = "localhost";
$user = "root"; 
$password = ""; // U
$dbname = "intrance_prep_app"; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo "Unauthorized. Please log in.";
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$total   = (int)($data['total'] ?? 0);
$correct = (int)($data['correct'] ?? 0);
$wrong   = $total - $correct;
$subject = strtolower(trim($data['subject'] ?? ''));
$email   = $_SESSION['email']; 

$columnMap = [
  'biology' => 'biology_questions',
  'physics' => 'physics_questions',
  'chemistry' => 'chemistry_questions',
  'math' => 'math_questions',
  'english' => 'english_questions',
  'history' => 'history_questions',
  'geography' => 'geography_questions',
  'civics' => 'civics_questions',
  'economics' => 'economics_questions',
  'ict' => 'ict_questions',
    'aptitude' => 'aptitude_questions'
];

if (!isset($columnMap[$subject])) {
    http_response_code(400);
    echo "Invalid subject: $subject";
    exit();
}

$subjectColumn = $columnMap[$subject];

try {
    $stmt = $conn->prepare("
        UPDATE user_stats
        SET total_questions = total_questions + ?,
            correct_answers = correct_answers + ?,
            wrong_answers = wrong_answers + ?,
            $subjectColumn = $subjectColumn + ?
        WHERE user_email = ?
    ");
    $stmt->bind_param("iiiis", $total, $correct, $wrong, $total, $email);
    $stmt->execute();

    echo "Stats updated successfully.";
} catch (Exception $e) {
    http_response_code(500);
    echo "Error updating stats: " . $e->getMessage();
}
?>
