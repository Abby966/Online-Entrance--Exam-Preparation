<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "intrance_prep_app";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['email']) && isset($_COOKIE['remember_me_token'])) {
    $token = $_COOKIE['remember_me_token'];

    $stmt = $conn->prepare("SELECT email FROM remember_me WHERE token = ?");
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($emailFromDb);
        if ($stmt->fetch()) {
            $_SESSION['email'] = $emailFromDb;
            $_SESSION['remember_token'] = $token;
        }
        $stmt->close();
    }
}

$sql = "SELECT name FROM courses";
$result = $conn->query($sql);

$contactError = '';
$contactSuccess = '';

if (isset($_SESSION['contactError'])) {
    $contactError = $_SESSION['contactError'];
    unset($_SESSION['contactError']);
}

if (isset($_SESSION['contactSuccess'])) {
    $contactSuccess = $_SESSION['contactSuccess'];
    unset($_SESSION['contactSuccess']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        $_SESSION['contactError'] = 'You must log in first to send a message.';
    } else {
        $email = $_SESSION['email'];
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (strlen($subject) < 3 || strlen($message) < 10) {
            $_SESSION['contactError'] = 'Please write a valid subject and message.';
        } else {
            $to = "youradmin@example.com"; 

            $cleanSubject = filter_var($subject, FILTER_SANITIZE_STRING);
            $cleanMessage = filter_var($message, FILTER_SANITIZE_STRING);
            $cleanEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

            if (!$cleanEmail) {
                $_SESSION['contactError'] = 'Invalid user email.';
            } else {
                $headers = "From: $cleanEmail\r\n" .
                           "Reply-To: $cleanEmail\r\n" .
                           "Content-Type: text/plain; charset=utf-8\r\n";

                $body = "From: $cleanEmail\n\nSubject: $cleanSubject\n\nMessage:\n$cleanMessage";

                if (mail($to, $cleanSubject, $body, $headers)) {
                    $_SESSION['contactSuccess'] = 'Message sent successfully!';
                } else {
                    $_SESSION['contactError'] = 'Failed to send message.';
                }
            }
        }
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "#contact");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>IntrancePrep | Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="styles/main.css" />
</head>
<body>

<header>
  <div class="logo">
    <img src="images/graduation.png" alt="IntrancePrep Logo" />
    <span>IntrancePrep</span>
  </div>
  <nav>
    <a href="#courses">Courses</a>
    <a href="#contact">Contact</a>
    <a href="account.php">Account</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-content">
    <h2>Prepare Smart for Your Entrance Exam</h2>
    <p>Access beautifully crafted notes & challenging quizzes across 10 core subjects. Level up your preparation the modern way.</p>
    <button onclick="scrollToCourses()">Explore Courses</button>
  </div>
</section>

<main class="subjects" id="courses">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()):
      $course = $row['name'];
      $slug = strtolower(str_replace(' ', '-', $course));
      $img = "images/{$slug}.png";
    ?>
      <a href="type.php?course=<?= urlencode($slug) ?>" class="subject-card">
        <img class="subject-icon" src="<?= htmlspecialchars($img, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($course, ENT_QUOTES) ?> Icon" />
        <h3><?= htmlspecialchars($course, ENT_QUOTES) ?></h3>
      </a>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No courses available.</p>
  <?php endif; ?>
</main>

<section class="contact" id="contact">
  <div class="contact-container">
    <h2>Contact Us</h2>
    <p>If you have any questions, feedback, or need assistance, feel free to reach out. We're here to help!</p>

    <form action="" method="post" class="contact-form" onsubmit="return validateContactForm()">
      <div class="form-group">
        <label for="contact-subject">Subject</label>
        <input id="contact-subject" type="text" name="subject" required />
      </div>
      <div class="form-group">
        <label for="contact-message">Message</label>
        <textarea id="contact-message" name="message" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn-submit">Send Message</button>
    </form>

    <?php if (!empty($contactError)): ?>
      <p style="color: red; margin-top: 10px;"><?= htmlspecialchars($contactError, ENT_QUOTES) ?></p>
    <?php elseif (!empty($contactSuccess)): ?>
      <p style="color: green; margin-top: 10px;"><?= htmlspecialchars($contactSuccess, ENT_QUOTES) ?></p>
    <?php endif; ?>
  </div>
</section>

<footer>
  <div class="footer-inner">
    <div class="footer-col about">
      <h3>About IntrancePrep</h3>
      <p>Your go‑to platform for smart entrance exam prep. Sharpen your knowledge and reach your goals!</p>
    </div>
    <div class="footer-col links">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#courses">Courses</a></li>
        <li><a href="account.php">My Account</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div>
    <div class="footer-col social">
      <h3>Follow Us</h3>
      <div class="social-icons">
        <img src="images/facebook.png" alt="Facebook" />
        <img src="images/X.png" alt="Twitter" />
        <img src="images/linkeden.png" alt="LinkedIn" />
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?= date('Y') ?> IntrancePrep. All rights reserved.</p>
  </div>
</footer>

<script>
function scrollToCourses() {
  document.getElementById('courses').scrollIntoView({ behavior: 'smooth' });
}

function validateContactForm() {
  const subject = document.getElementById('contact-subject').value.trim();
  const message = document.getElementById('contact-message').value.trim();

  if (subject.length < 3) {
    alert("Subject must be at least 3 characters.");
    return false;
  }

  if (message.length < 10) {
    alert("Message must be at least 10 characters.");
    return false;
  }

  return true;
}
</script>

</body>
</html>

