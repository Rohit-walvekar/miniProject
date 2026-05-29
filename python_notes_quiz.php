<?php
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php?redirect=python_notes_quiz.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Python Notes Quiz — 15 Questions (15 min)</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="c_notes_quiz.css">
</head>
<body>
  <div class="quiz-container">
    <h1>Python Notes — Quick Quiz</h1>

    <div id="start-screen" class="card">
      <h2>Ready? 15 Questions — 15 Minutes</h2>
      <p>Based on the Python notes. Select an option and it will immediately show feedback. You may attempt the quiz maximum 3 times.</p>
      <button id="start-btn" class="btn">Start Quiz</button>
    </div>

    <div id="quiz-form" class="card" style="display:none;">
      <div class="top-row">
        <div>Question <span id="current-q-number">1</span> / <span id="total-q">15</span></div>
        <div id="timer">15:00</div>
      </div>

      <div id="questions-container"></div>

      <div class="nav">
        <button id="prev-btn" class="btn" disabled>Previous</button>
        <button id="next-btn" class="btn">Next</button>
        <button id="submit-btn" class="btn primary" style="display:none;">Submit Quiz</button>
      </div>
    </div>

    <div id="results" class="card" style="display:none;">
      <h2>Quiz Results</h2>
      <p>Score: <span id="final-score"></span> / <span id="final-total">15</span></p>
      <div id="evaluation-message" class="evaluation"></div>
      <p>Time Taken: <span id="time-taken"></span></p>
      <button id="retry-btn" class="btn">Review Notes & Retake Quiz</button>
    </div>
  </div>

  <script src="python_notes_quiz.js" defer></script>
</body>
</html>
