const quizData = [
  { question: "Who created Python?", options: ["Guido van Rossum","Dennis Ritchie","James Gosling","Bjarne Stroustrup"], answer: "Guido van Rossum" },
  { question: "Which function is used to output text in Python?", options: ["println()","echo()","print()","output()"], answer: "print()" },
  { question: "What is the correct extension for Python files?", options: [".pt",".pyt",".py",".python"], answer: ".py" },
  { question: "Which keyword is used to create a function in Python?", options: ["function","def","fun","define"], answer: "def" },
  { question: "How do you create a variable with the numeric value 5?", options: ["x = 5","x = int(5)","Both are correct","None is correct"], answer: "Both are correct" },
  { question: "Which method can be used to remove any whitespace from both the beginning and the end of a string?", options: ["strip()","trim()","len()","ptrim()"], answer: "strip()" },
  { question: "Which method can be used to return a string in upper case?", options: ["upperCase()","toUpperCase()","upper()","uppercase()"], answer: "upper()" },
  { question: "Which operator is used to multiply numbers?", options: ["x","*","#","%"], answer: "*" },
  { question: "Which operator can be used to compare two values?", options: ["=","<>","==","><"], answer: "==" },
  { question: "Which of these collections defines a LIST?", options: ["{\"name\": \"apple\"}","[\"apple\", \"banana\"]","(\"apple\", \"banana\")","{\"apple\", \"banana\"}"], answer: "[\"apple\", \"banana\"]" },
  { question: "Which of these collections defines a TUPLE?", options: ["{\"name\": \"apple\"}","[\"apple\", \"banana\"]","(\"apple\", \"banana\")","{\"apple\", \"banana\"}"], answer: "(\"apple\", \"banana\")" },
  { question: "Which of these collections defines a DICTIONARY?", options: ["{\"name\": \"apple\"}","[\"apple\", \"banana\"]","(\"apple\", \"banana\")","{\"apple\", \"banana\"}"], answer: "{\"name\": \"apple\"}" },
  { question: "How do you start writing a while loop in Python?", options: ["while x > y:","while (x > y)","while x > y {","while x > y then:"], answer: "while x > y:" },
  { question: "How do you start writing a for loop in Python?", options: ["for x in y:","for x > y:","for each x in y:","for x in y then:"], answer: "for x in y:" },
  { question: "Which statement is used to stop a loop?", options: ["exit","stop","break","return"], answer: "break" }
];

let currentQuestionIndex = 0;
const userAnswers = new Array(quizData.length).fill(null);
let timerInterval;
let totalSeconds = 15 * 60;
let startTime = 0;
let finishTime = 0;

const startBtn = document.getElementById('start-btn');
const quizForm = document.getElementById('quiz-form');
const startScreen = document.getElementById('start-screen');
const questionsContainer = document.getElementById('questions-container');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const submitBtn = document.getElementById('submit-btn');
const currentQNumber = document.getElementById('current-q-number');
const totalQ = document.getElementById('total-q');
const timerEl = document.getElementById('timer');
const resultsEl = document.getElementById('results');
const finalScoreEl = document.getElementById('final-score');
const finalTotalEl = document.getElementById('final-total');
const evalMsg = document.getElementById('evaluation-message');
const timeTakenEl = document.getElementById('time-taken');
const retryBtn = document.getElementById('retry-btn');

totalQ.textContent = quizData.length;
finalTotalEl.textContent = quizData.length;

startBtn && startBtn.addEventListener('click', startQuiz);
prevBtn && prevBtn.addEventListener('click', prevQuestion);
nextBtn && nextBtn.addEventListener('click', nextQuestion);
submitBtn && submitBtn.addEventListener('click', submitQuiz);
if (retryBtn) retryBtn.addEventListener('click', () => {
    window.location.href = "python.html";
});

function renderQuestion() {
  const q = quizData[currentQuestionIndex];
  const qNum = currentQuestionIndex + 1;
  const userAnswerData = userAnswers[currentQuestionIndex];
  const isAnswered = userAnswerData !== null;

  currentQNumber.textContent = qNum;

  const optionsHtml = q.options.map(opt => {
    const disabledAttr = isAnswered ? 'disabled' : '';
    return `<button class="option-btn" data-value="${escapeHtml(opt)}" ${disabledAttr}>${opt}</button>`;
  }).join('');

  questionsContainer.innerHTML = `
    <div class="question-card">
      <h3>Q${qNum}: ${q.question}</h3>
      <div class="options">${optionsHtml}</div>
    </div>
  `;

  document.querySelectorAll('.option-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      handleOptionClick(e.currentTarget);
    });
  });

  prevBtn.disabled = currentQuestionIndex === 0;
  nextBtn.style.display = currentQuestionIndex < quizData.length - 1 ? 'inline-block' : 'none';
  submitBtn.style.display = currentQuestionIndex === quizData.length - 1 ? 'inline-block' : 'none';

  if (isAnswered) {
    const selected = userAnswerData.selected;
    document.querySelectorAll('.option-btn').forEach(b => {
      const v = unescapeHtml(b.dataset.value);
      if (v === q.answer) b.classList.add('correct-answer');
      if (v === selected && v !== q.answer) b.classList.add('wrong-answer');
      b.disabled = true;
    });
  }
}

function handleOptionClick(button) {
  const selected = unescapeHtml(button.dataset.value);
  const q = quizData[currentQuestionIndex];
  const isCorrect = selected === q.answer;

  userAnswers[currentQuestionIndex] = { selected, result: isCorrect ? 'correct' : 'incorrect' };
  document.querySelectorAll('.option-btn').forEach(b => {
    const v = unescapeHtml(b.dataset.value);
    b.disabled = true;
    if (v === q.answer) b.classList.add('correct-answer');
    if (v === selected && !isCorrect) b.classList.add('wrong-answer');
  });
}

function nextQuestion() {
  if (currentQuestionIndex < quizData.length - 1) {
    currentQuestionIndex++;
    renderQuestion();
  }
}
function prevQuestion() {
  if (currentQuestionIndex > 0) {
    currentQuestionIndex--;
    renderQuestion();
  }
}

function startQuiz() {
  startScreen.style.display = 'none';
  quizForm.style.display = 'block';
  startTime = Date.now();
  totalSeconds = 15 * 60;
  startTimer();
  renderQuestion();
}

function startTimer() {
  updateTimerDisplay();
  timerInterval = setInterval(() => {
    totalSeconds--;
    updateTimerDisplay();
    if (totalSeconds <= 0) {
      clearInterval(timerInterval);
      alert("Time's up — quiz will be submitted automatically.");
      submitQuiz();
    }
  }, 1000);
}

function updateTimerDisplay() {
  const m = Math.floor(totalSeconds / 60);
  const s = totalSeconds % 60;
  timerEl.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
}

function submitQuiz() {
  clearInterval(timerInterval);
  finishTime = Date.now();
  const totalTimeMs = finishTime - startTime;
  const minutesTaken = Math.floor(totalTimeMs / 60000);
  const secondsTaken = Math.floor((totalTimeMs % 60000) / 1000);

  let score = userAnswers.filter(a => a && a.result === 'correct').length;
  let total = quizData.length;

  const fd = new FormData();
  fd.append('score', score);
  fd.append('total', total);
  fetch('submit_python_notes_quiz.php', {
    method: 'POST',
    body: fd,
    credentials: 'same-origin'
  })
  .then(r => r.text())
  .then(data => {
    if (data.trim() === 'limit_reached') {
      alert('You have already attempted this quiz 3 times. You cannot submit again.');
    } else if (data.trim() === 'success') {
      console.log('Quiz saved successfully.');
    } else {
      alert('There was a problem saving your quiz result.');
    }
  })
  .catch(err => {
    alert('Network error while saving result.');
  });

  quizForm.style.display = 'none';
  resultsEl.style.display = 'block';
  finalScoreEl.textContent = score;
  timeTakenEl.textContent = `${minutesTaken} min ${secondsTaken} sec`;
  displayEvaluation(score);
}

function displayEvaluation(score) {
  if (score >= 13) {
    evalMsg.textContent = 'Excellent! You have strong fundamentals.';
    evalMsg.className = 'evaluation pass';
  } else if (score >= 10) {
    evalMsg.textContent = 'Good job! A bit more practice will help.';
    evalMsg.className = 'evaluation pass';
  } else {
    evalMsg.textContent = 'Keep practicing the notes and try again.';
    evalMsg.className = 'evaluation fail';
  }
}

function escapeHtml(s) {
  return String(s).replaceAll('"','&quot;').replaceAll("'", '&#039;').replaceAll('<','&lt;').replaceAll('>','&gt;');
}
function unescapeHtml(s) {
  return String(s).replaceAll('&quot;','"').replaceAll('&#039;',"'" ).replaceAll('&lt;','<').replaceAll('&gt;','>');
}

window.startQuiz = startQuiz;
window.prevQuestion = prevQuestion;
window.nextQuestion = nextQuestion;
window.submitQuiz = submitQuiz;
