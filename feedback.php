<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php?redirect=feedback.php");
    exit();
}

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'] ?? $name; 

    $sql = "INSERT INTO feedback (user_id, name, email, message)
            VALUES ($user_id, '$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        logActivity($conn, $user_id, $username, 'User submitted feedback');
        echo "<script>alert('Thank you for your feedback!');
              window.location='miniProject.php';</script>";
    } else {
        echo "<script>alert('Something went wrong: " . $conn->error . "');
              window.location='feedback.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback | Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { 
            outfit: ['Outfit', 'sans-serif'],
            inter: ['Inter', 'sans-serif'] 
          }
        }
      }
    }
    </script>
    <style>
      body { font-family: 'Inter', sans-serif; }
      h1, h2, h3, .font-outfit { font-family: 'Outfit', sans-serif; }
      @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
      .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) both; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#F1F5F9] p-6 antialiased relative overflow-hidden">

  <!-- Background Decorative Elements -->
  <div class="absolute top-0 left-0 w-full h-full opacity-40">
    <div class="absolute -top-48 -left-48 w-[600px] h-[600px] bg-indigo-200/50 rounded-full blur-[120px]"></div>
    <div class="absolute -bottom-48 -right-48 w-[600px] h-[600px] bg-purple-200/50 rounded-full blur-[120px]"></div>
  </div>

  <div class="animate-fade-up relative w-full max-w-xl">
    <div class="flex items-center justify-center gap-3 mb-8">
      <div class="w-12 h-12 bg-indigo-600 rounded-[18px] flex items-center justify-center shadow-2xl shadow-indigo-200">
        <i class="fa-solid fa-comments text-white text-2xl"></i>
      </div>
      <h1 class="text-4xl font-black tracking-tighter text-slate-900">Feedback<span class="text-indigo-600">.</span></h1>
    </div>

    <div class="bg-white/80 backdrop-blur-2xl rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white p-8 md:p-10">
      <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-slate-900 mb-2">We'd Love Your Input</h2>
        <p class="text-slate-500 font-medium">Your feedback helps us make Noted better for everyone.</p>
      </div>

      <form action="feedback.php" method="POST" class="space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Your Name</label>
            <div class="relative">
              <i class="fa-solid fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              <input type="text" name="name" placeholder="John Doe" required
                class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
          </div>
          <div class="space-y-2">
            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
            <div class="relative">
              <i class="fa-solid fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              <input type="email" name="email" placeholder="john@example.com" required
                class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Your Message</label>
          <div class="relative">
            <i class="fa-solid fa-message absolute left-5 top-6 text-slate-400 text-sm"></i>
            <textarea name="message" rows="4" placeholder="Tell us what you think..." required
              class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all resize-none"></textarea>
          </div>
        </div>

        <button type="submit" name="submit"
          class="w-full py-4 mt-4 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 active:scale-[0.98] transition-all cursor-pointer">
          Submit Feedback
        </button>
      </form>

      <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-500 font-medium">
          Changed your mind? <a href="miniProject.php" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Go back home</a>
        </p>
      </div>
    </div>
  </div>

</body>
</html>
