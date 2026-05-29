<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['userType'];

    if ($role == 'admin') {
        $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = 'admin';

            header("Location: admin.html");
            exit();
        } else {
            echo "<script>alert('Invalid Admin Credentials!'); window.location.href='login.php';</script>";
            exit();
        }
    } 
    elseif ($role == 'user') {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];  

            $_SESSION['role'] = 'user';

            header("Location: miniProject.php");
            exit();
        } else {
            echo "<script>alert('Invalid User Credentials!'); window.location.href='login.php';</script>";
            exit();
        }
    } 
    else {
        echo "<script>alert('Please select a valid user role!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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

  <div class="animate-fade-up relative w-full max-w-md">
    <!-- Login Card -->
    <div class="bg-white/80 backdrop-blur-2xl rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white p-8 md:p-10">
      <!-- Unified Logo and Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="w-10 h-10 bg-indigo-600 rounded-[14px] flex items-center justify-center shadow-xl shadow-indigo-200">
            <i class="fa-solid fa-note-sticky text-white text-xl"></i>
          </div>
          <h1 class="text-3xl font-black tracking-tighter text-slate-900">Noted<span class="text-indigo-600">.</span></h1>
        </div>
        <h2 class="text-2xl font-black text-slate-900 mb-2">Welcome Back</h2>
        <p class="text-sm text-slate-500 font-medium leading-relaxed px-4">Access your study materials and tracking dashboard.</p>
      </div>

      <form action="login.php" method="POST" class="space-y-4">
        <div class="space-y-2">
          <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
          <div class="relative">
            <i class="fa-solid fa-at absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="username" placeholder="Enter username" required
              class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
          <div class="relative">
            <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="password" name="password" placeholder="••••••••" required
              class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Select Identity</label>
          <div class="relative">
            <i class="fa-solid fa-user-shield absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <select name="userType" required
              class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer appearance-none">
              <option value="">Who are you?</option>
              <option value="user">Student / Learner</option>
              <option value="admin">Platform Admin</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
          </div>
        </div>

        <button type="submit" name="login"
          class="w-full py-4 mt-4 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 active:scale-[0.98] transition-all cursor-pointer">
          Sign In Now
        </button>
      </form>

      <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-500 font-medium">
          New here? <a href="reg.php" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Create account</a>
        </p>
      </div>
    </div>

    <!-- Help Link -->
    <p class="text-center mt-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">
      <a href="miniProject.php" class="hover:text-slate-600 transition-colors"><i class="fa-solid fa-arrow-left mr-2"></i> Back to Homepage</a>
    </p>
  </div>

</body>
</html>
