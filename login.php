<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';



if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['userType'];

    if ($role == 'admin') {
        $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = 'admin';

            header("Location: admin.html");
            exit();
        } else {
            echo "<script>alert('Invalid Admin Credentials!'); window.location.href='login.php';</script>";
            exit();
        }
    } 
    elseif ($role == 'user') {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];  

            $_SESSION['role'] = 'user';

            header("Location: miniProject.php");
            exit();
        } else {
            echo "<script>alert('Invalid User Credentials!'); window.location.href='login.php';</script>";
            exit();
        }
    } 
    else {
        echo "<script>alert('Please select a valid user role!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Register</title>
    <link rel="stylesheet" href="reg.css">
    <link rel="stylesheet" href="log.css">
</head>
<body>

    <div class="login-box">
        <h2>Login Form</h2>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="password" name="password" placeholder="Enter password" required>

            <select name="userType" required>
                <option value="">Select Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="login">Login</button>
        </form>

        <p class="register-text">
            Don’t have an account? <a href="reg.php">Register here</a>
        </p>
    </div>


    <script>
        document.getElementById("loginForm").addEventListener("submit", function(e){
            e.preventDefault();

            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const userType = document.getElementById("userType").value;
            const errorMsg = document.getElementById("errorMsg");

            if (!username || !password || !userType) {
                errorMsg.textContent = "Please fill in all fields!";
                return;
            }

            if (userType === "admin") {
                if (username === "admin" && password === "admin123") {
                    window.location.href = "admin.html";
                } else {
                    errorMsg.textContent = "Invalid admin credentials!";
                }
            } else if (userType === "user") {
                window.location.href = "miniProject.php";
            }
        });
    </script>

</body>
</html>
