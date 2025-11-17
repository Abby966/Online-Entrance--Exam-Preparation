<?php
session_start();
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email address.";
    } elseif (strlen($password) < 8 || !preg_match('/\d/', $password)) {
        $errorMessage = "Password must be at least 8 characters and include a number.";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=intrance_prep_app;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO users (email, name, password) VALUES (:email, :name, :password)");
            $stmt->execute([
                ':email' => $email,
                ':name' => $name,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: #fff; padding: 20px; border-radius: 8px; width: 350px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error-message { color: red; margin-bottom: 10px; }
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>Sign Up</h2>

    <?php if (!empty($errorMessage)) : ?>
        <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form action="signup.php" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
