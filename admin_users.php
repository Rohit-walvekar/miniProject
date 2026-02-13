<?php
session_start();
include 'db_connect.php';

$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users | Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="admin_users.php" class="active">Users</a></li>
                <li><a href="admin_feedback.php">Feedback</a></li>
                <li><a href="admin_upload.php">Upload Notes</a></li>
                <!-- <li><a href="view_notes.php">View Notes</a></li> -->
                <li><a href="admin_user_activity.php">User Activity</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header>
                <h1> Registered Users</h1>
            </header>

            <section class="data-section">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Registered On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['created_at']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
