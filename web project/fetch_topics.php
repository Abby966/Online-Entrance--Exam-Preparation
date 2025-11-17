<?php
include 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['course_id'])) {
    echo json_encode([]);
    exit;
}

$course_id = intval($_GET['course_id']);

$stmt = $conn->prepare("SELECT id, title FROM course_titles WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$topics = [];
while ($row = $result->fetch_assoc()) {
    $topics[] = $row; 
}

echo json_encode($topics);

$stmt->close();
$conn->close();
