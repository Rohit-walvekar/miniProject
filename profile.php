<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Noted</title>
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
          <i class="fa-solid fa-user text-3xl text-white"></i>
        </div>
        <h3 class="text-xl font-bold tracking-tight"><?php echo htmlspecialchars($username); ?></h3>
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1"><?php echo htmlspecialchars($email); ?></p>
      </div>
      <nav class="p-4 mt-6">
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-4 px-4">User Menu</div>
        <ul class="space-y-1">
          <li><a href="profile.php" class="sidebar-link active flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all hover:bg-white/5"><i class="fa-solid fa-id-card w-5 text-indigo-400"></i> My Profile</a></li>
          <li><a href="view_marks.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-chart-line w-5"></i> Performance</a></li>
          <li><a href="change_password.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-key w-5"></i> Security</a></li>
          <li><a href="miniProject.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-house w-5"></i> Return Home</a></li>
          <li class="pt-6 mt-6 border-t border-white/5"><a href="logout.php" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-rose-400 text-sm font-semibold transition-all hover:bg-rose-500/10 hover:text-rose-300"><i class="fa-solid fa-power-off w-5"></i> Sign Out</a></li>
        </ul>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-12">
      <header class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Account Settings</h1>
        <p class="text-slate-500 mt-2 font-medium">Update your personal information and profile preferences.</p>
      </header>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- FORM COLUMN -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm p-10">
            <form action="update_profile.php" method="POST" class="space-y-8">
              <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-2">
                  <label class="text-sm font-bold text-slate-700 ml-1">Full Name</label>
                  <div class="relative">
                    <i class="fa-solid fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($username); ?>" class="w-full pl-12 pr-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all" placeholder="Enter your full name">
                  </div>
                </div>
                <div class="space-y-2">
                  <label class="text-sm font-bold text-slate-700 ml-1 text-slate-400">Email Address <span class="text-[10px] font-black text-slate-300 uppercase ml-2">(Locked)</span></label>
                  <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="email" value="<?php echo htmlspecialchars($email); ?>" readonly class="w-full pl-12 pr-5 py-4 bg-slate-100 border border-slate-200 rounded-2xl text-sm text-slate-500 font-semibold cursor-not-allowed">
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Living Address</label>
                <div class="relative">
                  <i class="fa-solid fa-location-dot absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                  <input type="text" name="address" placeholder="Enter your current address" class="w-full pl-12 pr-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Mobile Connection</label>
                <div class="relative">
                  <i class="fa-solid fa-phone absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                  <input type="text" name="mobile" placeholder="+91 00000 00000" class="w-full pl-12 pr-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
              </div>

              <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Update takes effect immediately</p>
                <button class="px-10 py-4 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 transition-all cursor-pointer">Update Profile</button>
              </div>
            </form>
          </div>
        </div>

        <!-- INFO COLUMN -->
        <div class="space-y-8">
          <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[40px] p-8 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-10 rotate-12">
              <i class="fa-solid fa-award text-[180px]"></i>
            </div>
            <h4 class="text-xl font-bold mb-4">Study Tip</h4>
            <p class="text-indigo-100 text-sm leading-relaxed mb-6 font-medium">Regularly taking quizzes after reading notes can improve long-term retention by up to 60%.</p>
            <a href="miniProject.php#language" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-all">Start learning <i class="fa-solid fa-arrow-right"></i></a>
          </div>

          <div class="bg-white rounded-[40px] border border-slate-200 p-8 shadow-sm">
            <h4 class="text-lg font-bold text-slate-900 mb-6">Quick Actions</h4>
            <div class="space-y-4">
              <a href="view_marks.php" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-indigo-50 group transition-all">
                <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600">Download Report</span>
                <i class="fa-solid fa-download text-slate-400 group-hover:text-indigo-600"></i>
              </a>
              <a href="feedback.php" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-indigo-50 group transition-all">
                <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600">Submit Support Ticket</span>
                <i class="fa-solid fa-headset text-slate-400 group-hover:text-indigo-600"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
