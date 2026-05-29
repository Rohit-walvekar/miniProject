<?php
session_start();
$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noted | Programming Notes Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { 
            outfit: ['Outfit', 'sans-serif'],
            inter: ['Inter', 'sans-serif'] 
          },
          animation: {
            'float': 'float 6s ease-in-out infinite',
            'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(-20px)' },
            }
          }
        }
      }
    }
    </script>
    <style>
      body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
      h1, h2, h3, .font-outfit { font-family: 'Outfit', sans-serif; }
      .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
      .typing-anim { white-space: nowrap; overflow: hidden; display: inline-block; border-right: 3px solid #4F46E5; animation: typing 4s steps(40) forwards, blink .75s step-end infinite; }
      @keyframes typing { from { width: 0 } to { width: 100% } }
      @keyframes blink { from, to { border-color: transparent } 50% { border-color: #4F46E5 } }
      .profile-menu { opacity:0; transform:translateY(-8px); pointer-events:none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
      .profile-menu.show { opacity:1; transform:translateY(0); pointer-events:auto; }
      .gradient-text { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased selection:bg-indigo-100 selection:text-indigo-700">

<!-- HEADER -->
<header id="main-header" class="fixed top-0 w-full z-50 transition-all duration-500 py-6">
  <nav class="max-w-7xl mx-auto px-6 flex items-center justify-between">
    <div class="flex-shrink-0">
      <a href="#home" class="text-3xl font-black text-slate-900 tracking-tighter hover:scale-105 transition-transform flex items-center gap-2">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
          <i class="fa-solid fa-note-sticky text-white text-xl"></i>
        </div>
        <span>Noted<span class="text-indigo-600">.</span></span>
      </a>
    </div>
    
    <div class="hidden md:flex items-center gap-8 glass px-6 py-2 rounded-2xl shadow-sm border-slate-200/50">
      <ul class="flex items-center gap-1">
        <li><a href="#home" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-all">Home</a></li>
        <li><a href="#features" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-all">Features</a></li>
        <li><a href="#language" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-all">Languages</a></li>
        <li><a href="#about" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-all">About</a></li>
      </ul>
    </div>

    <div class="flex items-center gap-4">
      <?php if ($username): ?>
      <div class="relative">
        <button type="button" class="profile-btn group flex items-center gap-3 p-1.5 pr-4 rounded-full glass shadow-sm border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all cursor-pointer">
          <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white text-xs shadow-inner group-hover:rotate-12 transition-transform">
            <i class="fa-solid fa-user"></i>
          </div>
          <span class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars(ucfirst($username)); ?></span>
        </button>
        <ul class="profile-menu absolute top-full right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-indigo-900/10 border border-slate-200 p-2 z-50">
          <li><a href="profile.php" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-circle-user text-indigo-400"></i> My Profile</a></li>
          <li><a href="view_marks.php" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-chart-line text-indigo-400"></i> My Progress</a></li>
          <li class="my-2 border-t border-slate-100"></li>
          <li><button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 hover:opacity-90 transition-all cursor-pointer" onclick="window.location.href='logout.php'"><i class="fa-solid fa-power-off"></i> Logout</button></li>
        </ul>
      </div>
      <?php else: ?>
      <a href="login.php" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-slate-900 text-white shadow-lg shadow-slate-900/20 hover:bg-indigo-600 transition-all hover:-translate-y-0.5">Login</a>
      <?php endif; ?>
      <a href="feedback.php" class="hidden sm:flex w-11 h-11 items-center justify-center rounded-xl glass text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all" title="Feedback"><i class="fa-solid fa-message text-sm"></i></a>
    </div>
  </nav>
</header>

<main>
  <!-- HERO SECTION -->
  <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
    <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(79,70,229,0.05)_0%,rgba(248,250,252,1)_100%)]"></div>
    <div class="absolute -top-48 -right-48 w-96 h-96 bg-indigo-200/40 rounded-full blur-[120px] animate-pulse-slow"></div>
    <div class="absolute -bottom-48 -left-48 w-96 h-96 bg-purple-200/40 rounded-full blur-[120px] animate-pulse-slow"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-[10px] font-bold uppercase tracking-widest mb-8 animate-bounce">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
        </span>
        New C++ Tutorials Added
      </div>
      <h1 class="text-5xl md:text-7xl font-black text-slate-900 tracking-tight leading-none mb-6">
        Elevate Your <span class="gradient-text">Coding</span> Journey
      </h1>
      <div class="max-w-2xl mx-auto mb-12">
        <p class="text-lg text-slate-600 leading-relaxed font-medium">
          Comprehensive, structured, and easy-to-understand notes for <span class="typing-anim">C and C++ Programming...</span>
        </p>
      </div>
      
      <div class="flex flex-wrap items-center justify-center gap-6">
        <a href="#language" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all">Start Learning Now</a>
        <a href="#features" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition-all">Explore Features</a>
      </div>

      <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
        <div class="group text-center p-6 glass rounded-[32px] animate-float hover:bg-white transition-all duration-500" style="animation-delay: 0s;">
          <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-600 transition-colors">
            <i class="fa-solid fa-file-lines text-indigo-600 group-hover:text-white transition-colors text-xs"></i>
          </div>
          <p class="text-2xl font-black text-slate-900 mb-0.5">500+</p>
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Topics</p>
        </div>
        <div class="group text-center p-6 glass rounded-[32px] animate-float hover:bg-white transition-all duration-500" style="animation-delay: 1s;">
          <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition-colors">
            <i class="fa-solid fa-user-graduate text-purple-600 group-hover:text-white transition-colors text-xs"></i>
          </div>
          <p class="text-2xl font-black text-slate-900 mb-0.5">10k+</p>
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Learners</p>
        </div>
        <div class="group text-center p-6 glass rounded-[32px] animate-float hover:bg-white transition-all duration-500" style="animation-delay: 0.5s;">
          <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-cyan-600 transition-colors">
            <i class="fa-solid fa-bolt text-cyan-600 group-hover:text-white transition-colors text-xs"></i>
          </div>
          <p class="text-2xl font-black text-slate-900 mb-0.5">50+</p>
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Quizzes</p>
        </div>
        <div class="group text-center p-6 glass rounded-[32px] animate-float hover:bg-white transition-all duration-500" style="animation-delay: 1.5s;">
          <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-rose-600 transition-colors">
            <i class="fa-solid fa-star text-rose-600 group-hover:text-white transition-colors text-xs"></i>
          </div>
          <p class="text-2xl font-black text-slate-900 mb-0.5">4.9/5</p>
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Rating</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section id="features" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">Why Choose Noted?</h2>
        <p class="text-slate-500 font-medium max-w-xl mx-auto text-base">We provide everything you need to go from a beginner to an expert programmer.</p>
        <div class="w-24 h-1.5 bg-indigo-600 mx-auto rounded-full mt-6"></div>
      </div>

      <div class="grid md:grid-cols-3 gap-10">
        <div class="group p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
          <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-book-open text-indigo-600 text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 mb-4">Structured Content</h3>
          <p class="text-slate-500 leading-relaxed">Our notes are organized in a logical flow, making it easy to build your knowledge step-by-step without getting overwhelmed.</p>
        </div>

        <div class="group p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
          <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-lightbulb text-purple-600 text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 mb-4">Interactive Quizzes</h3>
          <p class="text-slate-500 leading-relaxed">Test your understanding with our topic-wise quizzes. Instant feedback helps you identify areas that need more focus.</p>
        </div>

        <div class="group p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
          <div class="w-16 h-16 bg-cyan-100 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-mobile-screen text-cyan-600 text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 mb-4">Responsive Design</h3>
          <p class="text-slate-500 leading-relaxed">Learn on the go! Our platform is fully optimized for all devices, so you can study anytime, anywhere.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- LANGUAGES SECTION -->
  <section id="language" class="py-32 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-16">Pick Your Language</h2>
      
      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <!-- C Language -->
        <div class="group relative bg-gradient-to-br from-indigo-500 to-purple-600 p-1 rounded-[40px] overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-500">
          <div class="relative bg-white rounded-[36px] p-8 flex flex-col items-center group-hover:bg-opacity-95 transition-all h-full">
            <div class="w-20 h-20 mb-6 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl font-black group-hover:bg-indigo-600 group-hover:text-white transition-colors">C</div>
            <h3 class="text-2xl font-black text-slate-900 mb-4">C Language</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 text-center flex-1">The foundation of modern programming. Master the core concepts of memory management and system architecture.</p>
            <div class="flex flex-col gap-3 w-full">
              <a href="c.html" class="py-3 bg-indigo-600 text-white rounded-xl text-center font-bold shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all">Read C Notes</a>
              <a href="c_notes_quiz.php" class="py-3 bg-indigo-50 text-indigo-600 rounded-xl text-center font-bold hover:bg-indigo-100 transition-all">Take C Quiz</a>
            </div>
          </div>
        </div>

        <!-- C++ Language -->
        <div class="group relative bg-gradient-to-br from-indigo-500 to-purple-600 p-1 rounded-[40px] overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-500">
          <div class="relative bg-white rounded-[36px] p-8 flex flex-col items-center group-hover:bg-opacity-95 transition-all h-full">
            <div class="w-20 h-20 mb-6 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl font-black group-hover:bg-indigo-600 group-hover:text-white transition-colors">C++</div>
            <h3 class="text-2xl font-black text-slate-900 mb-4">C++ Language</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 text-center flex-1">Powerful and versatile. Dive into Object-Oriented Programming and building high-performance applications.</p>
            <div class="flex flex-col gap-3 w-full">
              <a href="cpp.html" class="py-3 bg-indigo-600 text-white rounded-xl text-center font-bold shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all">Read C++ Notes</a>
              <a href="cpp_notes_quiz.php" class="py-3 bg-indigo-50 text-indigo-600 rounded-xl text-center font-bold hover:bg-indigo-100 transition-all">Take C++ Quiz</a>
            </div>
          </div>
        </div>

        <!-- Java Language -->
        <div class="group relative bg-gradient-to-br from-indigo-500 to-purple-600 p-1 rounded-[40px] overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-500">
          <div class="relative bg-white rounded-[36px] p-8 flex flex-col items-center group-hover:bg-opacity-95 transition-all h-full">
            <div class="w-20 h-20 mb-6 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl font-black group-hover:bg-indigo-600 group-hover:text-white transition-colors">J</div>
            <h3 class="text-2xl font-black text-slate-900 mb-4">Java Language</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 text-center flex-1">Object-oriented and platform-independent. Build secure, robust, and scalable enterprise-level applications.</p>
            <div class="flex flex-col gap-3 w-full">
              <a href="java.html" class="py-3 bg-indigo-600 text-white rounded-xl text-center font-bold shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all">Read Java Notes</a>
              <a href="java_notes_quiz.php" class="py-3 bg-indigo-50 text-indigo-600 rounded-xl text-center font-bold hover:bg-indigo-100 transition-all">Take Java Quiz</a>
            </div>
          </div>
        </div>

        <!-- Python Language -->
        <div class="group relative bg-gradient-to-br from-indigo-500 to-purple-600 p-1 rounded-[40px] overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-500">
          <div class="relative bg-white rounded-[36px] p-8 flex flex-col items-center group-hover:bg-opacity-95 transition-all h-full">
            <div class="w-20 h-20 mb-6 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl font-black group-hover:bg-indigo-600 group-hover:text-white transition-colors">P</div>
            <h3 class="text-2xl font-black text-slate-900 mb-4">Python Language</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 text-center flex-1">Simple, readable, and incredibly powerful. Perfect for AI, Data Science, and rapid web development.</p>
            <div class="flex flex-col gap-3 w-full">
              <a href="python.html" class="py-3 bg-indigo-600 text-white rounded-xl text-center font-bold shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all">Read Python Notes</a>
              <a href="python_notes_quiz.php" class="py-3 bg-indigo-50 text-indigo-600 rounded-xl text-center font-bold hover:bg-indigo-100 transition-all">Take Python Quiz</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS SECTION -->
  <section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 p-10 opacity-5">
      <i class="fa-solid fa-quote-right text-[150px]"></i>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3">What Students Say</h2>
        <p class="text-slate-500 font-medium max-w-lg mx-auto text-base">Real stories from real learners who transformed their coding skills.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        <div class="p-6 rounded-[32px] bg-slate-50 border border-slate-100 hover:scale-[1.02] transition-all duration-300">
          <div class="flex gap-1 text-amber-400 mb-4">
            <i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i>
          </div>
          <p class="text-slate-600 leading-relaxed italic mb-6 text-sm">"The C notes here are phenomenal. Everything is explained so clearly that even complex pointer arithmetic became easy to understand."</p>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xs">AS</div>
            <div>
              <p class="font-bold text-slate-900 text-sm">Aniket Sharma</p>
              <p class="text-[10px] font-bold text-slate-400 uppercase">CS Student</p>
            </div>
          </div>
        </div>

        <div class="p-6 rounded-[32px] bg-white border border-slate-200 shadow-xl shadow-indigo-500/5 hover:scale-[1.02] transition-all duration-300">
          <div class="flex gap-1 text-amber-400 mb-4">
            <i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i>
          </div>
          <p class="text-slate-600 leading-relaxed italic mb-6 text-sm">"I used this platform to prepare for my technical interviews. The C++ OOP section was a lifesaver. Highly recommended!"</p>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-xs">RP</div>
            <div>
              <p class="font-bold text-slate-900 text-sm">Rohini Patil</p>
              <p class="text-[10px] font-bold text-slate-400 uppercase">Engineer</p>
            </div>
          </div>
        </div>

        <div class="p-6 rounded-[32px] bg-slate-50 border border-slate-100 hover:scale-[1.02] transition-all duration-300">
          <div class="flex gap-1 text-amber-400 mb-4">
            <i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i><i class="fa-solid fa-star text-xs"></i>
          </div>
          <p class="text-slate-600 leading-relaxed italic mb-6 text-sm">"The interactive quizzes are addictive and super helpful. I've taken the C quiz multiple times to perfect my scores."</p>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-cyan-100 rounded-full flex items-center justify-center text-cyan-600 font-bold text-xs">VK</div>
            <div>
              <p class="font-bold text-slate-900 text-sm">Vijay Kumar</p>
              <p class="text-[10px] font-bold text-slate-400 uppercase">Learner</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ SECTION -->
  <section class="py-32 bg-white">
    <div class="max-w-4xl mx-auto px-6">
      <h2 class="text-4xl font-black text-slate-900 text-center mb-16">Frequently Asked Questions</h2>
      <div class="space-y-4">
        <details class="group p-6 rounded-3xl bg-slate-50 border border-slate-100 open:bg-white open:shadow-xl transition-all">
          <summary class="flex items-center justify-between font-bold text-lg text-slate-800 cursor-pointer list-none">
            Are these notes suitable for beginners?
            <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center group-open:rotate-180 transition-transform"><i class="fa-solid fa-chevron-down text-xs"></i></span>
          </summary>
          <p class="mt-4 text-slate-500 leading-relaxed">Yes! We start from the absolute basics and progress to advanced topics. Every concept is explained with simple examples.</p>
        </details>

        <details class="group p-6 rounded-3xl bg-slate-50 border border-slate-100 open:bg-white open:shadow-xl transition-all">
          <summary class="flex items-center justify-between font-bold text-lg text-slate-800 cursor-pointer list-none">
            Can I track my quiz results?
            <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center group-open:rotate-180 transition-transform"><i class="fa-solid fa-chevron-down text-xs"></i></span>
          </summary>
          <p class="mt-4 text-slate-500 leading-relaxed">Absolutely. Once you log in, your quiz scores are saved to your profile so you can monitor your progress over time.</p>
        </details>

        <details class="group p-6 rounded-3xl bg-slate-50 border border-slate-100 open:bg-white open:shadow-xl transition-all">
          <summary class="flex items-center justify-between font-bold text-lg text-slate-800 cursor-pointer list-none">
            Is the content updated regularly?
            <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center group-open:rotate-180 transition-transform"><i class="fa-solid fa-chevron-down text-xs"></i></span>
          </summary>
          <p class="mt-4 text-slate-500 leading-relaxed">Yes, our team of experts constantly reviews and updates the content to ensure it aligns with modern standards and practices.</p>
        </details>
      </div>
    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="about" class="py-32 bg-[#F8FAFC]">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-10 shadow-2xl shadow-indigo-200">
        <i class="fa-solid fa-users text-white text-3xl"></i>
      </div>
      <h2 class="text-4xl font-black text-slate-900 mb-8">Our Mission</h2>
      <p class="text-xl text-slate-500 leading-relaxed mb-8">
        At <strong class="text-slate-900">Noted</strong>, we believe quality education should be accessible to everyone. Our mission is to simplify complex programming concepts through structured learning paths and interactive challenges.
      </p>
      <p class="text-xl text-slate-500 leading-relaxed">
        Join thousands of students who are building their future with us. Whether you're preparing for exams or building your first app, we're here to support you.
      </p>
    </div>
  </section>
</main>

<!-- FOOTER -->
<footer class="bg-slate-900 text-white pt-24 pb-12">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-4 gap-12 pb-16 border-b border-slate-800">
      <div class="col-span-1 md:col-span-1">
        <a href="#" class="text-2xl font-black tracking-tighter flex items-center gap-2 mb-6">
          <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-note-sticky text-white text-base"></i>
          </div>
          <span>Noted<span class="text-indigo-500">.</span></span>
        </a>
        <p class="text-slate-400 text-sm leading-relaxed">Your path to programming mastery. Empowering students with the best resources since 2024.</p>
      </div>
      
      <div>
        <h4 class="text-slate-100 font-bold mb-6">Quick Links</h4>
        <ul class="space-y-4">
          <li><a href="#home" class="text-slate-400 text-sm hover:text-white transition-colors">Home</a></li>
          <li><a href="#features" class="text-slate-400 text-sm hover:text-white transition-colors">Features</a></li>
          <li><a href="#language" class="text-slate-400 text-sm hover:text-white transition-colors">Languages</a></li>
          <li><a href="feedback.php" class="text-slate-400 text-sm hover:text-white transition-colors">Feedback</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-slate-100 font-bold mb-6">Resources</h4>
        <ul class="space-y-4">
          <li><a href="c.html" class="text-slate-400 text-sm hover:text-white transition-colors">C Tutorials</a></li>
          <li><a href="cpp.html" class="text-slate-400 text-sm hover:text-white transition-colors">C++ Tutorials</a></li>
          <li><a href="profile.php" class="text-slate-400 text-sm hover:text-white transition-colors">My Account</a></li>
          <li><a href="view_marks.php" class="text-slate-400 text-sm hover:text-white transition-colors">Progress Tracking</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-slate-100 font-bold mb-6">Newsletter</h4>
        <p class="text-slate-400 text-sm mb-4">Get the latest updates and new notes.</p>
        <div class="flex gap-2">
          <input type="email" placeholder="Email address" class="bg-slate-800 border-none rounded-xl px-4 py-2.5 text-sm w-full focus:ring-2 focus:ring-indigo-500 outline-none">
          <button class="bg-indigo-600 px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition-all"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
      </div>
    </div>
    
    <div class="pt-12 flex flex-col md:flex-row items-center justify-between gap-6">
      <p class="text-slate-500 text-sm">&copy; 2025 Noted. Handcrafted with passion.</p>
      <div class="flex gap-6">
        <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-github"></i></a>
        <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.querySelector(".profile-btn");
  const menu = document.querySelector(".profile-menu");
  const header = document.getElementById("main-header");
  const navContainer = header.querySelector("nav");

  // Toggle Profile Menu
  if (btn && menu) {
    btn.addEventListener("click", (e) => { e.stopPropagation(); menu.classList.toggle("show"); });
    document.addEventListener("click", (e) => { if (!menu.contains(e.target) && !btn.contains(e.target)) menu.classList.remove("show"); });
  }

  // Scroll Effect
  window.addEventListener("scroll", () => {
    if (window.scrollY > 20) {
      header.classList.add("bg-white/80", "backdrop-blur-xl", "shadow-lg", "shadow-slate-200/50", "py-4");
      header.classList.remove("py-6");
    } else {
      header.classList.remove("bg-white/80", "backdrop-blur-xl", "shadow-lg", "shadow-slate-200/50", "py-4");
      header.classList.add("py-6");
    }
  });

  // Reveal animations on scroll
  const observerOptions = { threshold: 0.1 };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("opacity-100", "translate-y-0");
        entry.target.classList.remove("opacity-0", "translate-y-10");
      }
    });
  }, observerOptions);

  document.querySelectorAll("section > div").forEach(el => {
    el.classList.add("transition-all", "duration-1000", "opacity-0", "translate-y-10");
    observer.observe(el);
  });
});
</script>
</body>
</html>