<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$query = $conn->prepare("SELECT * FROM quiz_results WHERE user_id = ? ORDER BY attempt_time DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Marks</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="profile-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-info">
            <div class="avatar"></div>
            <h3><?php echo $username; ?></h3>
            <p><?php echo $_SESSION['email']; ?></p>
        </div>

        <ul class="menu">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="miniProject.php">Back to Notes</a></li>
            <li class="active"><a href="view_marks.php">View Marks</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="profile-details">
        <h2>Your Quiz Marks</h2>

        <table border="1" cellpadding="10" width="100%">
            <tr>
                <th>Quiz Name</th>
                <th>Score</th>
                <th>Total</th>
                <th>Attempt</th>
                <th>Date</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['quiz_name']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['total']; ?></td>
                    <td><?php echo $row['attempt_number']; ?></td>
                    <td><?php echo $row['attempt_time']; ?></td>
                </tr>
            <?php } ?>
        </table>

    </div>
</div>

</body>
</html>
