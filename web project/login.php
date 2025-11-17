<?php
session_start();
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $rememberMe = isset($_POST["remember_me"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email address.";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=intrance_prep_app;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT name, password FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user['name'];

                if ($rememberMe) {
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = date('Y-m-d H:i:s', time() + 60*60*24*30); // 30 days

                    // Save token to DB
                    $stmt2 = $pdo->prepare("
                        INSERT INTO remember_me (email, token, expires_at)
                        VALUES (:email, :token, :expires_at)
                        ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at
                    ");
                    $stmt2->execute([
                        ':email' => $email,
                        ':token' => $token,
                        ':expires_at' => $expiresAt
                    ]);

                    // Set cookie
                    setcookie("remember_me_token", $token, [
                        'expires' => time() + 60*60*24*30,
                        'path' => '/',
                        'secure' => isset($_SERVER['HTTPS']),
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                }

                header("Location: account.php");
                exit();
            } else {
                $errorMessage = "❌ Invalid email or password.";
            }

        } catch (PDOException $e) {
            $errorMessage = "❌ Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: #fff; padding: 20px; border-radius: 8px; width: 350px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error-message { color: red; margin-bottom: 10px; }
        a { color: #007bff; text-decoration: none; }
        label.remember-me { display: flex; align-items: center; margin-bottom: 15px; }
        label.remember-me input { margin-right: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>

    <?php if (!empty($errorMessage)) : ?>
        <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <label class="remember-me">
            <input type="checkbox" name="remember_me"> Remember Me
        </label>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>
</body>
</html>
