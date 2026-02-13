<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="profile-container">

    <div class="sidebar">
        <div class="user-info">
            <div class="avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <h3><?php echo $username; ?></h3>
            <p><?php echo $email; ?></p>
        </div>

        <ul class="menu">
            <li class="active"><a href="profile.php">My Profile</a></li>
            <li><a href="miniProject.php">Back to Notes</a></li>
            <li><a href="view_marks.php">View Marks</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="profile-details">
        <h2>My Profile</h2>

        <form action="update_profile.php" method="POST">
            <label>Full Name</label>
            <input type="text" name="fullname" value="<?php echo $username; ?>">

            <label>Email</label>
            <input type="email" value="<?php echo $email; ?>" readonly>

            <label>Address</label>
            <input type="text" name="address" placeholder="Enter your address">

            <label>Mobile Number</label>
            <input type="text" name="mobile" placeholder="Enter mobile number">

            <button class="save-btn">Save Changes</button>
        </form>
    </div>

</div>

</body>
</html>
