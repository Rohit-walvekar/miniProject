<?php
include 'db_connect.php'; 

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $file = $_FILES['noteFile']['name'];

    if ($file != "") {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($file);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['noteFile']['tmp_name'], $targetFile)) {
            $sql = "INSERT INTO notes (title, subject, description, file_path) 
                    VALUES ('$title', '$subject', '$description', '$targetFile')";
            if ($conn->query($sql)) {
                $message = "Note uploaded successfully!";
            } else {
                $message = "Database error: " . $conn->error;
            }
        } else {
            $message = "File upload failed!";
        }
    } else {
        $message = "Please select a file!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Notes | Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="admin_upload.css">
</head>
<body>
<div class="admin-container">
    
    <aside class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.html">Dashboard</a></li>
            <li><a href="admin_users.php">Users</a></li>
            <li><a href="admin_feedback.php">Feedback</a></li>
            <li><a href="admin_upload.php" class="active">Upload Notes</a></li>
            <!--<li><a href="view_notes.php">View Notes</a></li>-->
            <li><a href="admin_user_activity.php">User Activity</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1>Upload Notes</h1>
            <p>Status: <span style="color: green;">Connected </span></p>
        </header>

        <section class="upload-card">
            <?php if ($message): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="admin_upload.php" method="POST" enctype="multipart/form-data">
                <label>Title:</label>
                <input type="text" name="title" placeholder="Enter note title" required>

                <label>Subject:</label>
                <input type="text" name="subject" placeholder="Enter subject" required>

                <label>Description:</label>
                <textarea name="description" rows="3" placeholder="Short description" required></textarea>

                <label>Select File:</label>
                <input type="file" name="noteFile" accept=".pdf,.docx,.pptx,.txt" required>

                <button type="submit">Upload Note</button>
            </form>
        </section>

        <section class="uploaded-notes">
            <h2>Uploaded Notes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>File</th>
                        <th>Uploaded On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM notes ORDER BY uploaded_on DESC");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['title']}</td>
                                <td>{$row['subject']}</td>
                                <td>{$row['description']}</td>
                                <td><a class='view-link' href='{$row['file_path']}' target='_blank'>View</a></td>
                                <td>{$row['uploaded_on']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No notes uploaded yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>
