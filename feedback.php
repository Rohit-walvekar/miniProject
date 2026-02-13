<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';



if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php?redirect=feedback.php");
    exit();
}

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'] ?? $name; 

    $sql = "INSERT INTO feedback (user_id, name, email, message)
            VALUES ($user_id, '$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        logActivity($conn, $user_id, $username, 'User submitted feedback');

        echo "<script>alert('Thank you for your feedback!');
              window.location='miniProject.php';</script>";
    } else {
        echo "<script>alert('Something went wrong: " . $conn->error . "');
              window.location='feedback.html';</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | Notes Provider</title>
    <link rel="stylesheet" href="feedback.css">
    <link rel="stylesheet" href="feedback.php">
</head>


<body>
    <div class="feedback-container">
        <div class="feedback-box">
            <h2>We value your feedback</h2>
            <p>Please take a moment to share your thoughts with us.</p>

            <form id="feedbackForm" action="feedback.php" method="POST">
                <div class="input-group">
                    <input type="text" name="name" id="name" placeholder="Enter your name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <textarea name="message" id="message" placeholder="Write your feedback here..." required></textarea>
                </div>
                <button type="submit" name="submit">Send Feedback</button>
            </form>

            <div class="back-link">
                <a href="miniProject.php">← Back to Home</a>
            </div>
        </div>
    </div>

    <script src="feedback.js"></script>
</body>
</html>
