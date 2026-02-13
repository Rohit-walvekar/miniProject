<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['change_pass'])) {
    $user_id = $_SESSION['user_id'];

    $old_pass = $_POST['old_password'];
    $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $res = $check->get_result()->fetch_assoc();

    if (!password_verify($old_pass, $res['password'])) {
        $message = "Old password is incorrect!";
    } else {
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $new_pass, $user_id);
        $update->execute();
        $message = "Password changed successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="profile-container">

    <div class="sidebar">
        <div class="user-info">
            <div class="avatar"></div>
            <h3><?php echo $_SESSION['username']; ?></h3>
            <p><?php echo $_SESSION['email']; ?></p>
        </div>

        <ul class="menu">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="miniProject.php">Back to Notes</a></li>
            <li><a href="view_marks.php">View Marks</a></li>
            <li class="active"><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="profile-details">
        <h2>Change Password</h2>
        
        <p style="color: red;"><?php echo $message; ?></p>

        <form method="POST">
            <label>Old Password</label>
            <input type="password" name="old_password" required>

            <label>New Password</label>
            <input type="password" name="new_password" required>

            <button class="save-btn" name="change_pass">Update Password</button>
        </form>

    </div>
</div>

</body>
</html>
