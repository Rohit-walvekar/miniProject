<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$messageType = "";

if (isset($_POST['change_pass'])) {
    $user_id = $_SESSION['user_id'];

    $old_pass = $_POST['old_password'];
    $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $res = $check->get_result()->fetch_assoc();

    // Note: If you stored passwords as plain text previously, password_verify might fail.
    // Assuming you use hashed passwords as per line 16.
    if (!password_verify($old_pass, $res['password'])) {
        $message = "Old password is incorrect!";
        $messageType = "error";
    } else {
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $new_pass, $user_id);
        $update->execute();
        $message = "Password changed successfully!";
        $messageType = "success";
    }
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Settings | Noted</title>
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
      .sidebar-link.active { background: rgba(255, 255, 255, 0.1); color: white; border-right: 4px solid #4F46E5; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased">
  <div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-900 text-white flex-shrink-0 sticky top-0 h-screen overflow-y-auto z-50 shadow-2xl">
      <div class="p-8 text-center border-b border-white/5">
        <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-[24px] mx-auto flex items-center justify-center mb-4 shadow-xl shadow-indigo-500/20 rotate-3 hover:rotate-0 transition-transform duration-300">
          <i class="fa-solid fa-shield-halved text-3xl text-white"></i>
        </div>
        <h3 class="text-xl font-bold tracking-tight"><?php echo htmlspecialchars($username); ?></h3>
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1"><?php echo htmlspecialchars($email); ?></p>
      </div>
      <nav class="p-4 mt-6">
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-4 px-4">User Menu</div>
        <ul class="space-y-1">
          <li><a href="profile.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-id-card w-5"></i> My Profile</a></li>
          <li><a href="view_marks.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-chart-line w-5"></i> Performance</a></li>
          <li><a href="change_password.php" class="sidebar-link active flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all hover:bg-white/5"><i class="fa-solid fa-key w-5 text-indigo-400"></i> Security</a></li>
          <li><a href="miniProject.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-house w-5"></i> Return Home</a></li>
          <li class="pt-6 mt-6 border-t border-white/5"><a href="logout.php" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-rose-400 text-sm font-semibold transition-all hover:bg-rose-500/10 hover:text-rose-300"><i class="fa-solid fa-power-off w-5"></i> Sign Out</a></li>
        </ul>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-12">
      <header class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Security Settings</h1>
        <p class="text-slate-500 mt-2 font-medium">Keep your account protected by regularly updating your password.</p>
      </header>

      <div class="max-w-2xl">
        <?php if ($message): ?>
        <div class="mb-8 p-5 rounded-[24px] flex items-center gap-4 <?php echo $messageType == 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100'; ?>">
          <i class="fa-solid <?php echo $messageType == 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?> text-xl"></i>
          <p class="font-bold text-sm"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm p-8 md:p-10">
          <form method="POST" class="space-y-6">
            <div class="space-y-2">
              <label class="text-sm font-bold text-slate-700 ml-1">Current Password</label>
              <div class="relative">
                <i class="fa-solid fa-lock-open absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="password" name="old_password" required class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all" placeholder="••••••••">
              </div>
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-slate-700 ml-1">New Password</label>
              <div class="relative">
                <i class="fa-solid fa-key absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="password" name="new_password" required class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all" placeholder="Create a strong password">
              </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
              <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest max-w-[200px]">Ensure your password is at least 8 characters long</p>
              <button name="change_pass" class="px-10 py-3.5 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 transition-all cursor-pointer">Update Password</button>
            </div>
          </form>
        </div>

        <div class="mt-8 p-8 rounded-[40px] bg-indigo-50 border border-indigo-100 flex gap-6 items-center">
          <div class="w-16 h-16 bg-white rounded-2xl flex-shrink-0 flex items-center justify-center text-indigo-600 shadow-sm">
            <i class="fa-solid fa-fingerprint text-2xl"></i>
          </div>
          <div>
            <h4 class="font-bold text-slate-900 mb-1">Two-Factor Authentication</h4>
            <p class="text-sm text-slate-500 font-medium leading-relaxed">Add an extra layer of security to your account. (Coming soon to Noted platform)</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
