<?php
session_start();
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validation (basic)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email address.";
    } elseif (strlen($password) < 8 || !preg_match('/\d/', $password)) {
        $errorMessage = "Password must be at least 8 characters and include a number.";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=intrance_prep_app;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->beginTransaction();

            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (email, name, password) VALUES (:email, :name, :password)");
            $stmt->execute([
                ':email' => $email,
                ':name' => $name,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            // Initialize user stats
            $stmtStats = $pdo->prepare("INSERT INTO user_stats (user_email) VALUES (:email)");
            $stmtStats->execute([':email' => $email]);

            $pdo->commit();

            header("Location: login.php");
            exit();

        } catch (PDOException $e) {
            $pdo->rollBack();
            if ($e->getCode() === '23000') {
                $errorMessage = "An account with this email already exists.";
            } else {
                $errorMessage = "Something went wrong. Please try again later.";
            }
        }
    }
}
?>
