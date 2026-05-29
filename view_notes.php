<?php
include 'db_connect.php';

// Fetch all notes grouped by subject
$subjects = [];
$result = $conn->query("SELECT * FROM notes ORDER BY subject, uploaded_on DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[$row['subject']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Notes | Notes Provider</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="view_notes.css">
</head>
<body>

<aside class="sidebar">
  <h2>Admin Panel</h2>
  <ul>
    <li><a href="admin.html">Dashboard</a></li>
    <li><a href="admin_users.php">Users</a></li>
    <li><a href="admin_feedback.php">Feedback</a></li>
    <li><a href="admin_upload.php">Upload Notes</a></li>
    <li><a href="view_notes.php">View Notes</a></li>
    <li><a href="admin_user_activity.php" class="active">User Activity</a></li>
    <li><a href="admin_logout.php">Logout</a></li>
  </ul>

  <h2>Subjects</h2>
    <ul>
      <?php
      if (!empty($subjects)) {
          foreach ($subjects as $subject => $notes) {
              $anchor = strtolower(str_replace(' ', '-', $subject));
              echo "<li><a href='#$anchor'>$subject</a></li>";
          }
      } else {
          echo "<li><em>No subjects yet</em></li>";
      }
      ?>
    </ul>
  </aside>

  <main class="main-content">
    <?php
    if (!empty($subjects)) {
        foreach ($subjects as $subject => $notes) {
            $anchor = strtolower(str_replace(' ', '-', $subject));
            echo "<section id='$anchor' class='section-card'>";
            echo "<h1>$subject</h1>";

            foreach ($notes as $note) {
                echo "
                <div class='note-card'>
                  <h3>{$note['title']}</h3>
                  <p>{$note['description']}</p>
                  <a href='{$note['file_path']}' target='_blank'>📄 View / Download</a>
                  <div class='note-meta'>Uploaded on: {$note['uploaded_on']}</div>
                </div>
                ";
            }

            echo "</section>";
        }
    } else {
        echo "<p>No notes available yet.</p>";
    }
    ?>
  </main>

</body>
</html>
