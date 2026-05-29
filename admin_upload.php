<?php
session_start();
include 'db_connect.php'; 
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $description = $conn->real_escape_string($_POST['description']);
    $file = $_FILES['noteFile']['name'];
    if ($file != "") {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($file);
        if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
        if (move_uploaded_file($_FILES['noteFile']['tmp_name'], $targetFile)) {
            $sql = "INSERT INTO notes (title, subject, description, file_path) VALUES ('$title', '$subject', '$description', '$targetFile')";
            if ($conn->query($sql)) { 
              $message = "Content uploaded successfully!"; 
              $messageType = "success";
            } else { 
              $message = "Database error: " . $conn->error; 
              $messageType = "error";
            }
        } else { 
          $message = "File upload failed!"; 
          $messageType = "error";
        }
    } else { 
      $message = "Please select a file!"; 
      $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Content | Noted Admin</title>
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
          <li><a href="admin_feedback.php" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-slate-400 text-sm font-semibold transition-all hover:bg-white/5 hover:text-white"><i class="fa-solid fa-comments w-5"></i> User Feedback</a></li>
          <li><a href="admin_upload.php" class="sidebar-link active flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all hover:bg-white/5"><i class="fa-solid fa-cloud-arrow-up w-5 text-indigo-400"></i> Upload Content</a></li>
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
          <h1 class="text-4xl font-black text-slate-900 tracking-tight">Content Manager</h1>
          <p class="text-slate-500 mt-1 font-medium">Upload new study materials and notes for your students.</p>
        </div>
      </header>

      <div class="grid lg:grid-cols-3 gap-10">
        <!-- UPLOAD FORM -->
        <section class="lg:col-span-1">
          <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm p-10 sticky top-10">
            <h2 class="text-2xl font-black text-slate-900 mb-8">New Upload</h2>
            
            <?php if ($message): ?>
              <div class="mb-8 p-4 rounded-2xl flex items-center gap-3 <?php echo $messageType == 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100'; ?>">
                <i class="fa-solid <?php echo $messageType == 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
                <p class="text-xs font-bold"><?php echo $message; ?></p>
              </div>
            <?php endif; ?>

            <form action="admin_upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
              <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Title</label>
                <input type="text" name="title" placeholder="e.g. C Pointers Guide" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
              </div>
              <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Subject</label>
                <input type="text" name="subject" placeholder="e.g. Programming" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
              </div>
              <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Description</label>
                <textarea name="description" rows="3" placeholder="Brief summary of the content..." required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 font-semibold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all resize-none"></textarea>
              </div>
              <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Attachment</label>
                <div class="relative group">
                  <input type="file" name="noteFile" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                  <div class="w-full px-5 py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl flex flex-col items-center justify-center gap-3 group-hover:border-indigo-400 transition-all">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                      <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-400 group-hover:text-slate-600 transition-all">Click to browse or drag file</p>
                  </div>
                </div>
              </div>
              <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 transition-all cursor-pointer mt-4">Publish Content</button>
            </form>
          </div>
        </section>

        <!-- UPLOADED NOTES LIST -->
        <section class="lg:col-span-2">
          <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
              <h2 class="text-2xl font-black text-slate-900">Recent Uploads</h2>
              <i class="fa-solid fa-layer-group text-slate-300"></i>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="bg-slate-50/30">
                    <th class="px-10 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Content Details</th>
                    <th class="px-10 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Subject</th>
                    <th class="px-10 py-5 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Action</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  <?php
                  $result = $conn->query("SELECT * FROM notes ORDER BY uploaded_on DESC");
                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          echo "<tr class='hover:bg-slate-50/80 transition-colors group'>
                              <td class='px-10 py-6'>
                                <div class='flex items-center gap-4'>
                                  <div class='w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all'>
                                    <i class='fa-solid fa-file-pdf text-xl'></i>
                                  </div>
                                  <div>
                                    <p class='font-bold text-slate-900'>".htmlspecialchars($row['title'])."</p>
                                    <p class='text-[10px] font-bold text-slate-400 uppercase mt-1 truncate max-w-[200px]'>".htmlspecialchars($row['description'])."</p>
                                  </div>
                                </div>
                              </td>
                              <td class='px-10 py-6 text-xs font-black text-slate-500 uppercase tracking-wider'>".htmlspecialchars($row['subject'])."</td>
                              <td class='px-10 py-6 text-right'>
                                <a href='{$row['file_path']}' target='_blank' class='px-5 py-2.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-wider rounded-xl border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all'>View File</a>
                              </td>
                          </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='3' class='px-10 py-20 text-center text-slate-400 font-medium'>No content uploaded yet. Use the form to get started.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>
</body>
</html>
