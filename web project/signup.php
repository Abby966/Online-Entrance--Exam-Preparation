<?php
session_start();
require 'db.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO users (email, name, password) VALUES (:email, :name, :password)");
        $stmt->execute([
            ':email' => $email,
            ':name' => $name,
            ':password' => $hashedPassword
        ]);

        $insertStats = $pdo->prepare("INSERT INTO user_stats (user_email) VALUES (:email)");
        $insertStats->execute([':email' => $email]);

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="styles/signup.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
 
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/graduation.png" alt="IntrancePrep Logo" />
      <span>IntrancePrep</span>
    </div>
    <nav>
      <a href="main.php">Home</a>
      <a href="login.php">Login</a>
    </nav>
  </header>

  <div class="container">
    <h2>Strengthen Your Knowledge</h2>

    <form class="auth-box" action="signup.php" method="POST" autocomplete="off">
  <label for="name">Full Name</label>
  <input id="name" type="text" name="name" placeholder="Your full name" required autocomplete="off" />

  <label for="email">Email</label>
  <input type="email" name="email" placeholder="Email" required autocomplete="off" />

  <label for="password">Password</label>
  <input type="password" name="password" placeholder="Password" required autocomplete="new-password" />

  <button type="submit" class="btn-primary">Sign Up</button>

  <?php if (!empty($errorMessage)): ?>
    <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
  <?php endif; ?>
</form>

    <p class="switch-auth">Have an account? <a href="login.php">Sign in</a></p>
  </div>

  <script>
    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
      const name = form.name.value.trim();
      const email = form.email.value.trim();
      const password = form.password.value;

      const nameValid = /^[A-Za-z ]{3,}$/.test(name);
      const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
      const passwordValid = /^(?=.*\d).{8,}$/.test(password);

      if (!nameValid || !emailValid || !passwordValid) {
        e.preventDefault();

        const existing = document.querySelector('.error-message');
        if (existing) existing.remove();

        const errorDiv = document.createElement('div');
        errorDiv.classList.add('error-message');

        let message = "";
        if (!nameValid) message += "- Name must be at least 3 letters<br>";
        if (!emailValid) message += "- Enter a valid email address<br>";
        if (!passwordValid) message += "- Password must be at least 8 characters and include a number<br>";

        errorDiv.innerHTML = message;

        form.appendChild(errorDiv);
      }
    });
  </script>
</body>
</html>
