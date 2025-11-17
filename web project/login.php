<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $rememberMe = isset($_POST["remember_me"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=intrance_prep_app;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch user
            $stmt = $pdo->prepare("SELECT name, password FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user['name'];

                if ($rememberMe) {
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days

                    // Store token in DB
                    $stmtToken = $pdo->prepare("
                        INSERT INTO remember_me (email, token, expires_at) 
                        VALUES (:email, :token, :expires_at)
                        ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at
                    ");
                    $stmtToken->execute([
                        ':email' => $email,
                        ':token' => $token,
                        ':expires_at' => $expiresAt
                    ]);

                    // Set cookie
                    setcookie("remember_me_token", $token, [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'secure' => isset($_SERVER['HTTPS']),
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                }

                header("Location: account.php");
                exit();
            } else {
                $error = "❌ Email or password is incorrect.";
            }

        } catch (PDOException $e) {
            $error = "Database error. Please try again later.";
        }
    }
}
?>
