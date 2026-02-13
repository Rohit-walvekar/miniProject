<?php
include 'db_connect.php';
include 'log_activity.php';

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['userType'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location='reg.php';</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($role == 'admin') {
        $check = "SELECT * FROM admins WHERE username = '$username'";
    } else {
        $check = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    }

    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email or username already exists!'); window.location='reg.php';</script>";
        exit();
    }

    if ($role == 'admin') {
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    }

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        logActivity($conn, $user_id, $username, 'User registered successfully');

        echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Create Account</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>

    <div class="login-box">
        <h2>Registration Portal</h2>

        <form action="reg.php" method="POST">
            <input type="text" name="fullname" placeholder="Enter full name" required>
            <input type="email" name="email" placeholder="Enter email" required>
            <input type="text" name="username" placeholder="Choose a username" required>
            <input type="password" name="password" placeholder="Create password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm password" required>

            <button type="submit" name="register">Register</button>
        </form>

        <p class="register-text">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>


    <script>
        document.getElementById("registerForm").addEventListener("submit", function(e){
            e.preventDefault();

            const fullname = document.getElementById("fullname").value.trim();
            const email = document.getElementById("email").value.trim();
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("confirmPassword").value.trim();
            const userType = document.getElementById("userType").value;
            const errorMsg = document.getElementById("errorMsg");

            if (!fullname || !email || !username || !password || !confirmPassword || !userType) {
                errorMsg.textContent = "Please fill in all fields!";
                return;
            }

            if (password !== confirmPassword) {
                errorMsg.textContent = "Passwords do not match!";
                return;
            }

            alert("Registration successful! Redirecting to login...");
            window.location.href = "login.php";
        });
    </script>

</body>
</html>
