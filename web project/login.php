<?php
$cookie_lifetime = 60 * 60 * 24 * 5;

session_set_cookie_params([
    'lifetime' => $cookie_lifetime,
    'path' => '/',
    'domain' => '', 
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $rememberMe = isset($_POST["remember_me"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $conn = new mysqli("localhost", "root", "", "intrance_prep_app");

        if ($conn->connect_error) {
            $error = "Database connection failed.";
        } else {
            $stmt = $conn->prepare("SELECT name, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $stmt->bind_result($name, $hashedPassword);
                    $stmt->fetch();

                    if (password_verify($password, $hashedPassword)) {
                        // Set session
                        $_SESSION["email"] = $email;
                        $_SESSION["name"] = $name;

                        if ($rememberMe) {
                            $token = bin2hex(random_bytes(32));
                            $expiresAt = date('Y-m-d H:i:s', time() + (86400 * 30)); 

                           
                            $stmt2 = $conn->prepare("INSERT INTO remember_me (email, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");
                            $stmt2->bind_param("sss", $email, $token, $expiresAt);
                            $stmt2->execute();
                            $stmt2->close();

                            // Set cookie (30 days)
                            setcookie("remember_me_token", $token, [
                                'expires' => time() + (86400 * 30),
                                'path' => '/',
                                'secure' => isset($_SERVER['HTTPS']),
                                'httponly' => true,
                                'samesite' => 'Lax'
                            ]);
                        }

                        $stmt->close();
                        $conn->close();

                        header("Location: account.php");
                        exit();
                    } else {
                        $error = "❌ Incorrect password.";
                    }
                } else {
                    $error = "❌ Email not found.";
                }
            } else {
                $error = "❌ Something went wrong. Try again.";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign In</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles/signin.css" />
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/graduation.png" alt="IntrancePrep Logo" />
      <span>IntrancePrep</span>
    </div>
    <nav>
      <a href="main.php">Home</a>
      <a href="signup.php">Sign Up</a>
    </nav>
  </header>

  <div class="container">
    <h2>Continue Your Journey</h2>

    <form class="auth-box" action="login.php" method="POST" autocomplete="off">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Email" required autocomplete="off" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" required autocomplete="new-password" />

      <label class="remember-me">
        <input type="checkbox" name="remember_me" />
        Remember Me
      </label>

      <button type="submit" class="btn-primary">Login</button>
    </form>

    <?php if (!empty($error)): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <p class="switch-auth">Don't have an account? <a href="signup.php">Sign Up</a></p>
  </div>
</body>
</html>
