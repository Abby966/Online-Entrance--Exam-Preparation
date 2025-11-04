<?php

session_start();

$host = "localhost"; $user = "root"; $password = ""; $dbname = "intrance_prep_app";
$conn = new mysqli($host, $user, $password, $dbname);

$course = $_GET['course'] ?? '';
$title  = $_GET['title'] ?? '';

$sql = "
  SELECT ct.id
  FROM course_titles ct
  JOIN courses c ON ct.course_id = c.id
  WHERE c.name = ? AND ct.title = ?
  LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $course, $title);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz – <?php echo htmlspecialchars($title); ?></title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f8fb;
      margin: 0; padding: 20px;
      display: flex; justify-content: center;
    }
    .quiz-container {
      max-width: 800px; width: 100%;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; color: #0077cc; margin-bottom: 30px; }
    .question-block {
      margin-bottom: 25px;
      padding: 20px;
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      background: #fdfdfd;
      display: none;
    }
    .question-block.visible { display: block; }
    .question-block p { font-weight: bold; margin-bottom: 10px; }
    .question-block label {
      display: block; margin-bottom: 8px; padding-left:10px; cursor:pointer;
      transition: color 0.3s, font-weight 0.3s;
    }
    input[type="radio"] { margin-right: 10px; }

    .button-container {
      display: flex; justify-content: space-between; gap: 10px; margin-top: 30px;
    }
    #load-more-btn, #submit-btn {
      padding: 12px 24px; font-size: 16px; border: none; border-radius: 8px;
      color: #fff; font-weight: bold; opacity: 0.5; cursor: not-allowed;
      transition: 0.3s;
    }
    #load-more-btn { background: #17a2b8; }
    #submit-btn { background: #28a745; }
    #load-more-btn.enabled, #submit-btn.enabled {
      opacity: 1; cursor: pointer;
    }
    .result {
      margin-top: 30px; text-align: center;
      font-size: 18px; font-weight: bold; color: #333;
    }
    #finish-btn {
  background: #dc3545;
  color: #fff;
  font-weight: bold;
  padding: 12px 24px;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  opacity: 0.5;
  cursor: not-allowed;
  transition: 0.3s;
}
#finish-btn.enabled {
  opacity: 1;
  cursor: pointer;
}

  </style>
</head>
<body>
  <div class="quiz-container">
<?php
if ($row = $result->fetch_assoc()) {
    $titleId = $row['id'];

    $quizStmt = $conn->prepare("SELECT * FROM quizzes WHERE title_id = ?");
    $quizStmt->bind_param("i", $titleId);
    $quizStmt->execute();
    $quizResult = $quizStmt->get_result();

    echo "<h2>Quiz: " . htmlspecialchars($title) . "</h2><form id='quiz-form'>";

    $qnum = 1; $correctAnswers = [];

    while ($quiz = $quizResult->fetch_assoc()) {
        $qid = $quiz['id'];
        $correctAnswers[$qid] = $quiz['correct_option'];
        echo "<div class='question-block' data-index='$qnum' data-qid='$qid'>";
        echo "<p>Q{$qnum}: " . htmlspecialchars($quiz['question']) . "</p>";
        foreach (['A','B','C','D'] as $opt) {
            $txt = htmlspecialchars($quiz["option_" . strtolower($opt)]);
            echo "<label><input type='radio' name='q{$qid}' value='$opt' > {$opt}. {$txt}</label>";
        }
        echo "</div>";
        $qnum++;
    }

    $total = $qnum - 1;

    echo "</form>";
    echo "<div class='button-container'>";
    echo "<button type='button' id='load-more-btn'>Load More</button>";
    echo "<button type='submit' form='quiz-form' id='submit-btn'>Check Answers</button>";
      echo "<button type='button' id='finish-btn'>Finish</button>";

    echo "</div>";
    echo "<div class='result' id='result'></div>";

    echo "<script>
      const correctAnswers = " . json_encode($correctAnswers) . ";
      const totalQuestions = $total;
    </script>";

    $quizStmt->close();
} else {
    echo "<p>Invalid course or topic selected.</p>";
}
$stmt->close();
$conn->close();
?>
<script>
  const form = document.getElementById('quiz-form');
  const loadMoreBtn = document.getElementById('load-more-btn');
  const submitBtn = document.getElementById('submit-btn');
  const resultDiv = document.getElementById('result');
    const finishBtn = document.getElementById('finish-btn');

  const questionBlocks = document.querySelectorAll('.question-block');
  let shown = 0, perLoad = 5;
  let totalScore = 0;
  const checkedQuestions = new Set();

  function showMore() {
    let count = 0;
    while (shown < questionBlocks.length && count < perLoad) {
      questionBlocks[shown].classList.add('visible');
      shown++; count++;
    }
    updateButtons();
  }

  function updateButtons() {
    const visibleBlocks = [...questionBlocks].filter(b => b.classList.contains('visible'));
    const answeredVisible = visibleBlocks.filter(b => {
      const qid = b.getAttribute('data-qid');
      return form.querySelector(`input[name="q${qid}"]:checked`);
    }).length;

    if (answeredVisible === visibleBlocks.length && visibleBlocks.length > 0) {
      submitBtn.classList.add('enabled');
      submitBtn.disabled = false;
       finishBtn.classList.add('enabled');
      finishBtn.disabled = false;
    } else {
      submitBtn.classList.remove('enabled');
      submitBtn.disabled = true;
       finishBtn.classList.remove('enabled');
      finishBtn.disabled = true;
    }

    if (shown < questionBlocks.length) {
      loadMoreBtn.classList.add('enabled');
      loadMoreBtn.disabled = false;
    } else {
      loadMoreBtn.classList.remove('enabled');
      loadMoreBtn.disabled = true;
    }
  }

  showMore();

  form.addEventListener('change', updateButtons);
  loadMoreBtn.addEventListener('click', () => { showMore(); updateButtons(); });

 form.addEventListener('submit', e => {
  
  e.preventDefault();
  document.querySelectorAll('.question-block.visible').forEach(block => {
    const qid = block.getAttribute('data-qid');
    const selected = form.querySelector(`input[name="q${qid}"]:checked`);
    const options = form.querySelectorAll(`input[name="q${qid}"]`);

    options.forEach(o => {
      o.disabled = true;
      const label = o.closest('label');
      label.style.color = 'black';
      label.style.fontWeight = 'normal';
    });

    if (selected && !checkedQuestions.has(qid)) {
      const isCorrect = selected.value === correctAnswers[qid];
      const label = selected.closest('label');
      label.style.color = isCorrect ? 'green' : 'red';
      label.style.fontWeight = 'bold';
      if (isCorrect) totalScore++;
      checkedQuestions.add(qid);
    } else if (selected) {
      const isCorrect = selected.value === correctAnswers[qid];
      const label = selected.closest('label');
      label.style.color = isCorrect ? 'green' : 'red';
      label.style.fontWeight = 'bold';
    }
  });

  resultDiv.innerHTML = `Your current score is <strong>${totalScore}</strong> out of <strong>${checkedQuestions.size}</strong> questions checked.`;
  resultDiv.scrollIntoView({ behavior: 'smooth' });

  updateButtons();
});
finishBtn.addEventListener('click', () => {
  
  const isLoggedIn = <?php echo isset($_SESSION['email']) ? 'true' : 'false'; ?>;

  if (!isLoggedIn) {
    window.location.href = 'account.php'; // Not logged in
    return;
  }

  let totalAttempted = 0;
  let correctAnswersCount = 0;

  document.querySelectorAll('.question-block.visible').forEach(block => {
    const qid = block.getAttribute('data-qid');
    const selected = form.querySelector(`input[name="q${qid}"]:checked`);

    if (selected) {
      totalAttempted++;
      if (selected.value === correctAnswers[qid]) {
        correctAnswersCount++;
      }
    }
  });

  const subject = "<?php echo htmlspecialchars(strtolower($course)); ?>";

  fetch('update_stats.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      total: totalAttempted,
      correct: correctAnswersCount,
      subject: subject
    })
  })
  .then(res => res.text())
  .then(data => {
    alert(data);
    history.go(-1);
  })
  .catch(err => alert("Error updating stats: " + err));
});




</script>

  </div>
</body>
</html>
