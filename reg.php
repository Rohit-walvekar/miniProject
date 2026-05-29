<?php
include 'db_connect.php';
include 'log_activity.php';

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['userType'] ?? 'user';

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location='reg.php';</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($role == 'admin') {
        $check = "SELECT * FROM admins WHERE username = '$username'";
    } else {
        $check = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    }

    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email or username already exists!'); window.location='reg.php';</script>";
        exit();
    }

    if ($role == 'admin') {
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    }

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        logActivity($conn, $user_id, $username, 'User registered successfully');
        echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Noted | Create Account</title>
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

  <div class="animate-fade-up relative w-full max-w-lg">
    <!-- Registration Card -->
    <div class="bg-white/80 backdrop-blur-2xl rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white p-8 md:p-10">
      <!-- Unified Logo and Header -->
      <div class="text-center mb-6">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="w-10 h-10 bg-indigo-600 rounded-[14px] flex items-center justify-center shadow-xl shadow-indigo-200">
            <i class="fa-solid fa-note-sticky text-white text-xl"></i>
          </div>
          <h1 class="text-3xl font-black tracking-tighter text-slate-900">Noted<span class="text-indigo-600">.</span></h1>
        </div>
        <h2 class="text-2xl font-black text-slate-900 mb-2">Create Account</h2>
        <p class="text-sm text-slate-500 font-medium">Join our community of learners today.</p>
      </div>

      <form action="reg.php" method="POST" class="space-y-3.5">
        <div class="grid md:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
            <div class="relative">
              <i class="fa-solid fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              <input type="text" name="fullname" id="fullname" placeholder="John Doe" required
                oninput="generateUsername(this.value)"
                class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
          </div>
          <div class="space-y-1.5">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
            <div class="relative">
              <i class="fa-solid fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              <input type="email" name="email" placeholder="john@example.com" required
                class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
          <div class="relative">
            <i class="fa-solid fa-at absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="username" id="username" placeholder="Generated automatically" required readonly
              class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-500 font-bold outline-none cursor-not-allowed">
            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[9px] font-black text-indigo-500 uppercase tracking-tighter">Auto-Gen</span>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
            <div class="relative">
              <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              <input type="password" name="password" placeholder="••••••••" required
                class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
          </div>
          <div class="space-y-1.5">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm</label>
            <div class="relative">
              <i class="fa-solid fa-circle-check absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
              <input type="password" name="confirmPassword" placeholder="••••••••" required
                class="w-full pl-12 pr-5 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
          </div>
        </div>

        <button type="submit" name="register"
          class="w-full py-4 mt-3 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 active:scale-[0.98] transition-all cursor-pointer">
          Create Account Now
        </button>
      </form>

      <div class="mt-6 pt-5 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-500 font-medium">
          Already a member? <a href="login.php" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Sign in here</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    function generateUsername(val) {
        const usernameInput = document.getElementById('username');
        if (!usernameInput) return;
        
        let name = val.trim().toLowerCase()
            .replace(/[^a-z0-9]/g, '')
            .substring(0, 8);
        
        if (name) {
            if (!window.sessionSuffix) {
                window.sessionSuffix = Math.floor(100 + Math.random() * 899);
            }
            usernameInput.value = name + "_" + window.sessionSuffix;
        } else {
            usernameInput.value = '';
        }
    }
  </script>

</body>
</html>
