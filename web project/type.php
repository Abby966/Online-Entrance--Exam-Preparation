
<?php
  $subject = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : 'unknown';
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Subjects</title>
 <style>
    header {
      background: rgba(255, 255, 255, 0.95);
      padding: 18px 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo img {
      width: 42px;
      height: 42px;
    }

    .logo span {
      color: #1d2b64;
      font-size: 28px;
      font-weight: 700;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: black;
      font-weight: 600;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #e94e77;
    }

    /* Body and Container */
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f6fa;
    }

    .card-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      padding: 50px 20px;
    }

    /* Subject Card Style */
    .subject-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 180px;
      height: 200px;
      background-color: white;
      text-decoration: none;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease;
      padding: 20px;
    }

    .subject-card:hover {
      transform: translateY(-5px);
    }

    .subject-icon {
      width: 80px;
      height: 80px;
      object-fit: contain;
      margin-bottom: 15px;
    }

    .subject-card h3 {
      color: #1d2b64;
      font-size: 18px;
      font-weight: 600;
      margin: 0;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">
      <img src="images/graduation.png" alt="IntrancePrep Logo" />
      <span>IntrancePrep</span>
    </div>
    <nav>
      <a href="main.php">Home</a>
      <a href="#account">Account</a>
    </nav>
  </header>

  <div class="card-container">
    <a href="titles.php?course=<?= $subject ?>&type=quiz" class="subject-card">
      <img class="subject-icon" src="images/quiz.png" alt="Quiz Icon" />
      <h3>Quizzes</h3>
    </a>

    <a href="titles.php?course=<?= $subject ?>&type=material" class="subject-card">
      <img class="subject-icon" src="images/material.png" alt="Materials Icon" />
      <h3>Materials</h3>
    </a>
  </div>

</body>
</html>
