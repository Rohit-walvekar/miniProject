<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$query = $conn->prepare("SELECT * FROM quiz_results WHERE user_id = ? ORDER BY attempt_time DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Performance | Noted</title>
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
          <i class="fa-solid fa-chart-bar text-3xl text-white"></i>
        </div>
        <h3 class="text-xl font-bold tracking-tight"><?php echo htmlspecialchars($username); ?></h3>
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1"><?php echo htmlspecialchars($email); ?></p>
      </div>
      <nav class="p-4 mt-6">
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-4 px-4">User Menu</div>
        <ul class="space-y-1">
          <li><a href="profile.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-id-card w-5"></i> My Profile</a></li>
          <li><a href="view_marks.php" class="sidebar-link active flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all hover:bg-white/5"><i class="fa-solid fa-chart-line w-5 text-indigo-400"></i> Performance</a></li>
          <li><a href="change_password.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-key w-5"></i> Security</a></li>
          <li><a href="miniProject.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-house w-5"></i> Return Home</a></li>
          <li class="pt-6 mt-6 border-t border-white/5"><a href="logout.php" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-rose-400 text-sm font-semibold transition-all hover:bg-rose-500/10 hover:text-rose-300"><i class="fa-solid fa-power-off w-5"></i> Sign Out</a></li>
        </ul>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-12">
      <header class="mb-12 flex items-center justify-between">
        <div>
          <h1 class="text-4xl font-black text-slate-900 tracking-tight">Quiz Analytics</h1>
          <p class="text-slate-500 mt-2 font-medium">Review your historical performance and progress across all topics.</p>
        </div>
        <div class="w-16 h-16 bg-white rounded-2xl border border-slate-200 flex items-center justify-center text-slate-500 shadow-sm">
          <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
      </header>

      <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 bg-slate-50/50">
          <h3 class="text-lg font-bold text-slate-900">Attempt History</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-slate-50/30">
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Quiz Topic</th>
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Score Achieved</th>
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Attempt #</th>
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Date & Time</th>
                <th class="px-8 py-5 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php if ($result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { 
                  $percentage = ($row['score'] / $row['total']) * 100;
                  $isPass = $percentage >= 50;
                ?>
                <tr class="hover:bg-slate-50/80 transition-colors group">
                  <td class="px-8 py-6">
                    <div class="flex items-center gap-4">
                      <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-black group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <?php echo strtoupper(substr($row['quiz_name'], 0, 1)); ?>
                      </div>
                      <span class="font-bold text-slate-900"><?php echo htmlspecialchars($row['quiz_name']); ?></span>
                    </div>
                  </td>
                  <td class="px-8 py-6">
                    <div class="flex items-center gap-3">
                      <span class="text-lg font-black <?php echo $isPass ? 'text-emerald-600' : 'text-rose-600'; ?> tabular-nums"><?php echo $row['score']; ?></span>
                      <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">/ <?php echo $row['total']; ?></span>
                    </div>
                  </td>
                  <td class="px-8 py-6">
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wide">Try #<?php echo $row['attempt_number']; ?></span>
                  </td>
                  <td class="px-8 py-6 text-sm font-semibold text-slate-500 tabular-nums"><?php echo $row['attempt_time']; ?></td>
                  <td class="px-8 py-6 text-right">
                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest <?php echo $isPass ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'; ?>">
                      <?php echo $isPass ? 'Passed' : 'Failed'; ?>
                    </span>
                  </td>
                </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="5" class="px-8 py-20 text-center">
                    <div class="max-w-xs mx-auto">
                      <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 text-3xl">
                        <i class="fa-solid fa-folder-open"></i>
                      </div>
                      <p class="text-slate-400 font-bold">No results found.</p>
                      <p class="text-xs font-medium text-slate-400 mt-2">Go ahead and take your first quiz to see your progress here!</p>
                      <a href="miniProject.php#language" class="inline-block mt-6 px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">Start a Quiz</a>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
