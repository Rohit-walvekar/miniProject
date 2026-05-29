<?php
session_start();
include 'db_connect.php';
$result = $conn->query("SELECT * FROM feedback ORDER BY submitted_at ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback | Noted Admin</title>
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
<body class="bg-[#F1F5F9] text-slate-900 antialiased">
  <div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-900 text-white flex-shrink-0 sticky top-0 h-screen overflow-y-auto z-50 shadow-2xl">
      <div class="p-8 pb-10 flex items-center gap-3">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
          <i class="fa-solid fa-shield-halved text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-black tracking-tight text-white">Noted<span class="text-indigo-500">Admin</span></h2>
      </div>
      
      <nav class="px-4">
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-4 px-4">Main Menu</div>
        <ul class="space-y-1">
          <li><a href="admin.html" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-chart-pie w-5"></i> Dashboard</a></li>
          <li><a href="admin_users.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-users w-5"></i> Manage Users</a></li>
          <li><a href="admin_feedback.php" class="sidebar-link active flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all hover:bg-white/5"><i class="fa-solid fa-comments w-5 text-indigo-400"></i> User Feedback</a></li>
          <li><a href="admin_upload.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-cloud-arrow-up w-5"></i> Upload Content</a></li>
          <li><a href="admin_user_activity.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-clock-rotate-left w-5"></i> Activity Logs</a></li>
        </ul>

        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mt-10 mb-4 px-4">System</div>
        <ul class="space-y-1">
          <li><a href="admin_logout.php" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-rose-400 text-sm font-semibold transition-all hover:bg-rose-500/10 hover:text-rose-300"><i class="fa-solid fa-power-off w-5"></i> Sign Out</a></li>
        </ul>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 overflow-y-auto">
      <header class="flex items-center justify-between mb-12">
        <div>
          <h1 class="text-4xl font-black text-slate-900 tracking-tight">Community Feedback</h1>
          <p class="text-slate-500 mt-1 font-medium">Review and respond to messages from your platform users.</p>
        </div>
        <div class="flex items-center gap-4">
          <div class="px-4 py-2 bg-purple-50 rounded-xl border border-purple-100 flex items-center gap-2 text-purple-600 font-bold text-sm">
            <i class="fa-solid fa-inbox"></i>
            <?php echo $result->num_rows; ?> Submissions
          </div>
        </div>
      </header>

      <section class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-slate-50/50">
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">User Info</th>
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Message Content</th>
                <th class="px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Submission Date</th>
                <th class="px-8 py-5 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<tr class='hover:bg-slate-50/80 transition-colors group'>
                          <td class='px-8 py-6'>
                            <div class='flex flex-col'>
                              <p class='font-bold text-slate-900 leading-none'>".htmlspecialchars($row['name'])."</p>
                              <p class='text-[10px] font-bold text-slate-400 uppercase mt-1'>".htmlspecialchars($row['email'])."</p>
                            </div>
                          </td>
                          <td class='px-8 py-6 text-sm font-medium text-slate-600 max-w-xs'>
                            <p class='truncate' title='".htmlspecialchars($row['message'])."'>".htmlspecialchars($row['message'])."</p>
                          </td>
                          <td class='px-8 py-6 text-sm font-medium text-slate-500'>{$row['submitted_at']}</td>
                          <td class='px-8 py-6 text-right'>
                            <button class='text-indigo-600 hover:text-indigo-800 font-bold text-xs uppercase tracking-widest transition-colors'>View Full</button>
                          </td>
                      </tr>";
                  }
              } else {
                  echo "<tr><td colspan='4' class='px-8 py-20 text-center text-slate-400 font-medium'>No feedback found in the database.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
