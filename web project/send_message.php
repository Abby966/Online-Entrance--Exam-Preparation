<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_SESSION['email'])) {
    echo "<script>alert('You must log in first to send a message.');</script>";
    return;
  }

  $email = $_SESSION['email'];
  $subject = trim($_POST['subject']);
  $message = trim($_POST['message']);

  if (strlen($subject) < 3 || strlen($message) < 10) {
    echo "<script>alert('Please write a valid subject and message.');</script>";
    return;
  }

  $to = "youradmin@example.com"; 
  $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8\r\n";
  $body = "From: $email\n\nSubject: $subject\n\nMessage:\n$message";

  if (mail($to, $subject, $body, $headers)) {
    echo "<script>alert('Message sent successfully!');</script>";
  } else {
    echo "<script>alert('Failed to send message.');</script>";
  }
}
?>
