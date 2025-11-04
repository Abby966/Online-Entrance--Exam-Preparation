<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "intrance_prep_app";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['email']) && isset($_COOKIE['remember_me_token'])) {
    $token = $_COOKIE['remember_me_token'];

    $stmt = $conn->prepare("SELECT email, expires_at FROM remember_me WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (strtotime($row['expires_at']) > time()) {
            $_SESSION['email'] = $row['email'];

            $stmt2 = $conn->prepare("SELECT name FROM users WHERE email = ?");
            $stmt2->bind_param("s", $row['email']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows === 1) {
                $user = $result2->fetch_assoc();
                $_SESSION['name'] = $user['name'];
            }
            $stmt2->close();
        } else {
            setcookie("remember_me_token", "", time() - 3600, "/", "", isset($_SERVER['HTTPS']), true);
            $delStmt = $conn->prepare("DELETE FROM remember_me WHERE token = ?");
            $delStmt->bind_param("s", $token);
            $delStmt->execute();
            $delStmt->close();
        }
    }
    $stmt->close();
}

if (!isset($_SESSION['email'])) {
    $conn->close();
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$userEmail = $_SESSION['email'];

$sql = "SELECT 
    total_questions, 
    correct_answers, 
    wrong_answers, 
    biology_questions, 
    physics_questions,
    chemistry_questions,
    math_questions,
    english_questions,
    history_questions,
    geography_questions,
    civics_questions,
    aptitude_questions,
    ict_questions
FROM user_stats WHERE user_email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = (int)$row['total_questions'];
    $correct = (int)$row['correct_answers'];
    $wrong = (int)$row['wrong_answers'];

    $subjects = [
        'Biology' => (int)$row['biology_questions'],
        'Physics' => (int)$row['physics_questions'],
        'Chemistry' => (int)$row['chemistry_questions'],
        'Math' => (int)$row['math_questions'],
        'English' => (int)$row['english_questions'],
        'History' => (int)$row['history_questions'],
        'Geography' => (int)$row['geography_questions'],
        'Civics' => (int)$row['civics_questions'],
        'Aptitude' => (int)$row['aptitude_questions'],
        'ICT' => (int)$row['ict_questions'],
    ];

    $subjectPercents = [];
    foreach ($subjects as $subject => $count) {
        $subjectPercents[$subject] = $total > 0 ? round(($count / $total) * 100, 1) : 0;
    }

    $correctPercent = $total > 0 ? round(($correct / $total) * 100, 1) : 0;
    $wrongPercent = $total > 0 ? round(($wrong / $total) * 100, 1) : 0;

} else {
    $total = $correct = $wrong = 0;
    $subjects = array_fill_keys([
        'Biology', 'Physics', 'Chemistry', 'Math', 'English',
        'History', 'Geography', 'Civics', 'Aptitude', 'ICT'
    ], 0);
    $subjectPercents = array_fill_keys(array_keys($subjects), 0);
    $correctPercent = $wrongPercent = 0;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Account - IntrancePrep</title>
  <link rel="stylesheet" href="styles/account.css" />
</head>
<body>

<header>
  <div class="logo">
    <img src="images/graduation.png" alt="Logo" />
    <span>IntrancePrep</span>
  </div>
  <nav>
    <a href="main.php">Home</a>
  </nav>
</header>

<div class="account-container">
  <h1>Welcome, <?= htmlspecialchars($name) ?>!</h1>

  <div class="stats">
    <p><strong>Total Questions:</strong> <?= $total ?></p>
    <p><strong>Correct:</strong> <?= $correct ?> (<?= $correctPercent ?>%)</p>
    <p><strong>Wrong:</strong> <?= $wrong ?> (<?= $wrongPercent ?>%)</p>
  </div>

  <div class="charts">
    <div class="chart-box">
      <canvas id="pieChart"></canvas>
    </div>
    <div class="chart-box">
      <canvas id="barChart"></canvas>
    </div>
  </div>

  <form action="logout.php" method="POST">
    <button type="submit">Logout</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const subjectLabels = <?= json_encode(array_keys($subjects)) ?>;
  const subjectCounts = <?= json_encode(array_values($subjects)) ?>;
  const subjectPercents = <?= json_encode(array_values($subjectPercents)) ?>;
  const total = <?= $total ?>;
  const correct = <?= $correct ?>;
  const wrong = <?= $wrong ?>;
  const correctPercent = <?= $correctPercent ?>;
  const wrongPercent = <?= $wrongPercent ?>;

  const pieTooltip = subjectCounts.map((count, i) => ({
    label: subjectLabels[i],
    count: count,
    percent: subjectPercents[i]
  }));

  new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
      labels: subjectLabels,
      datasets: [{
        label: 'Subject-wise Questions',
        data: subjectCounts,
        backgroundColor: [
          '#FF6384', '#36A2EB', '#FFCE56', '#81C784', '#BA68C8',
          '#4DB6AC', '#FFD54F', '#90A4AE', '#F06292', '#64B5F6'
        ]
      }]
    },
    options: {
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => {
              const data = pieTooltip[ctx.dataIndex];
              return `${data.label}: ${data.count} (${data.percent}%)`;
            }
          }
        },
        legend: { position: 'bottom' }
      }
    }
  });

  new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
      labels: ['Total', 'Correct', 'Wrong'],
      datasets: [{
        label: 'Question Stats',
        data: [total, correct, wrong],
        backgroundColor: ['#42A5F5', '#66BB6A', '#EF5350']
      }]
    },
    options: {
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => {
              if (ctx.label === 'Correct') return `${ctx.label}: ${correct} (${correctPercent}%)`;
              if (ctx.label === 'Wrong') return `${ctx.label}: ${wrong} (${wrongPercent}%)`;
              return `Total: ${total}`;
            }
          }
        },
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });
</script>

</body>
</html>
