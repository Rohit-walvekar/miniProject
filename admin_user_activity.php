<?php
session_start();
include 'db_connect.php';

// Fetch all quiz attempts
$query = "
    SELECT 
        u.username, 
        qr.quiz_name, 
        qr.score, 
        qr.total, 
        qr.attempt_number, 
        qr.attempt_time
    FROM quiz_results qr
    JOIN users u ON qr.user_id = u.id
    ORDER BY qr.attempt_time DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Quiz Activity | Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="admin_users.php">Users</a></li>
                <li><a href="admin_feedback.php">Feedback</a></li>
                <li><a href="admin_upload.php">Upload Notes</a></li>
                <!-- <li><a href="view_notes.php">View Notes</a></li> -->
                <li><a href="admin_user_activity.php" class="active">User Activity</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </aside>
        
        <main class="main-content">

            <header>
                <h1>All Users Quiz Attempts</h1>
            </header>

            <section class="data-section">

                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Quiz Name</th>
                            <th>Score</th>
                            <th>Total</th>
                            <th>Attempt No.</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>{$row['username']}</td>
                                    <td>{$row['quiz_name']}</td>
                                    <td>{$row['score']}</td>
                                    <td>{$row['total']}</td>
                                    <td>{$row['attempt_number']}</td>
                                    <td>{$row['attempt_time']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No quiz attempts found.</td></tr>";
                        }
                        ?>
                    </tbody>

                </table>

            </section>

        </main>

    </div>

</body>
</html>
