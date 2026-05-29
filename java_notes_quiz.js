const quizData = [
  { question: "Which company created Java?", options: ["Sun Microsystems","Microsoft","Google","Oracle"], answer: "Sun Microsystems" },
  { question: "Which method is the entry point for any Java program?", options: ["start()","init()","main()","run()"], answer: "main()" },
  { question: "Which keyword is used to create a subclass in Java?", options: ["subclass","extends","implements","inherits"], answer: "extends" },
  { question: "What is the size of 'int' data type in Java?", options: ["2 bytes","4 bytes","8 bytes","1 byte"], answer: "4 bytes" },
  { question: "Which data type is used to create a variable that should store text?", options: ["String","myString","Txt","string"], answer: "String" },
  { question: "How do you insert COMMENTS in Java code?", options: ["# This is a comment","// This is a comment","/* This is a comment","-- This is a comment"], answer: "// This is a comment" },
  { question: "Which operator can be used to compare two values?", options: ["=","<>","==","><"], answer: "==" },
  { question: "To declare an array in Java, define the variable type with:", options: ["{}","[]","()","<>"], answer: "[]" },
  { question: "Which keyword is used to create an object in Java?", options: ["class","new","object","create"], answer: "new" },
  { question: "Which method can be used to find the length of a string?", options: ["getSize()","length()","getLength()","len()"], answer: "length()" },
  { question: "Which keyword is used to import a package in Java?", options: ["include","package","import","using"], answer: "import" },
  { question: "Which access modifier makes a member accessible only within its own class?", options: ["public","private","protected","default"], answer: "private" },
  { question: "What is the extension of Java bytecode files?", options: [".java",".js",".class",".txt"], answer: ".class" },
  { question: "Which of these is NOT a primitive data type?", options: ["int","boolean","char","String"], answer: "String" },
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
    window.location.href = "java.html";
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
  fetch('submit_java_notes_quiz.php', {
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
