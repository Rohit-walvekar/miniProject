// --- QUIZ DATA (15 questions for C++) ---
const quizData = [
  { 
    question: "Who created the C++ programming language?", 
    options: ["Bjarne Stroustrup","Dennis Ritchie","James Gosling","Anders Hejlsberg"], 
    answer: "Bjarne Stroustrup" 
  },

  { 
    question: "Which header is used for standard input/output in C++ (stream IO)?", 
    options: ["&ltstdio.h&gt","&ltiostream&gt","&ltstring&gt","&ltfstream&gt"], 
    answer: "<iostream>" 
  },

  { 
    question: "Which is the correct way to print to standard output in C++?", 
    options: ["cout << \"Hello\";","printf(\"Hello\");","System.out.println(\"Hello\");","print(\"Hello\")"], 
    answer: "cout << \"Hello\";" 
  },

  { 
    question: "Which keyword is used to define a class in C++?", 
    options: ["struct","class","interface","module"], 
    answer: "class" 
  },

  { 
    question: "Which operator is used for scope resolution in C++?", 
    options: ["::",".","->",";"], 
    answer: "::" 
  },

  { 
    question: "Which container stores elements in contiguous memory and provides random access?",
    options: ["std::list","std::vector","std::map","std::set"], 
    answer: "std::vector" 
  },

  { 
    question: "What is the correct way to declare a pointer to int?", 
    options: ["int p;","int* p;","p: int*;","pointer<int> p;"], 
    answer: "int* p;" 
  },

  { 
    question: "Which keyword prevents modification of a variable?", 
    options: ["static","immutable","const","volatile"], 
    answer: "const" 
  },

  { 
    question: "Which loop will always execute its body at least once?", 
    options: ["for","while","do-while","foreach"], 
    answer: "do-while" 
  },

  { 
    question: "Which of these is used for dynamic memory allocation in C++?", 
    options: ["malloc","new","alloc","create"], 
    answer: "new" 
  },

  { 
    question: "Which is the correct way to define a function returning nothing?", 
    options: ["void f(){}","int f(){}","null f(){}","empty f(){}"], 
    answer: "void f(){}" 
  },

  { 
    question: "Which operator is used to access members via pointer?", 
    options: [".","->","::","*"], 
    answer: "->" 
  },

  { 
    question: "Which STL container keeps items sorted automatically?", 
    options: ["std::vector","std::list","std::set","std::stack"], 
    answer: "std::set" 
  },

  { 
    question: "Which keyword enables polymorphism via method overriding?", 
    options: ["virtual","override","dynamic","static"], 
    answer: "virtual" 
  },

  { 
    question: "Which is a correct C++ string type from std:: library?", 
    options: ["string_t","std::string","char[]","cstring"], 
    answer: "std::string" 
  }
];

let currentQuestionIndex = 0;
const userAnswers = new Array(quizData.length).fill(null);
let timerInterval;
let totalSeconds = 15 * 60; // 15 minutes
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

if (startBtn) startBtn.addEventListener('click', startQuiz);
if (prevBtn) prevBtn.addEventListener('click', prevQuestion);
if (nextBtn) nextBtn.addEventListener('click', nextQuestion);
if (submitBtn) submitBtn.addEventListener('click', submitQuiz);
if (retryBtn) retryBtn.addEventListener('click', () => {
    window.location.href = "cpp.html";
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
    if (v === q.answer) {
      b.classList.add('correct-answer');
    }
    if (v === selected && !isCorrect) {
      b.classList.add('wrong-answer');
    }
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
  console.log("Submit Quiz function triggered!");

  clearInterval(timerInterval);
  finishTime = Date.now();
  const totalTimeMs = finishTime - startTime;
  const minutesTaken = Math.floor(totalTimeMs / 60000);
  const secondsTaken = Math.floor((totalTimeMs % 60000) / 1000);

  let score = userAnswers.filter(a => a && a.result === 'correct').length;
  let total = quizData.length;

  console.log("Sending to PHP...", score, total);

  const fd = new FormData();
  fd.append('score', score);
  fd.append('total', total);

  fetch('submit_cpp_notes_quiz.php', {
    method: 'POST',
    body: fd,
    credentials: 'same-origin'
  })
  .then(r => r.text())
  .then(data => {
    console.log('Server response:', data);
    if (data.trim() === 'limit_reached') {
      alert('You have already attempted this quiz 3 times. You cannot submit again.');
    } else if (data.trim() === 'success') {
      console.log('Quiz saved successfully.');
    } else {
      console.warn('Unexpected server response:', data);
      alert('There was a problem saving your quiz result.');
    }
  })
  .catch(err => {
    console.error('Fetch error:', err);
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
