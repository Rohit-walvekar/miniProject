<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    echo "<script>alert('You have been logged out successfully.');</script>";
}

$html = file_get_contents("miniProject.php");

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $html = str_replace(
        '<a target="_blank" href="signUp.php">
                    <li>Login</li>
                </a>',
        "<a href='logout.php'><li>Logout ($username)</li></a>",
        $html
    );
} else {
    $html = str_replace(
        '<a target="_blank" href="signUp.php">
                    <li>Login</li>
                </a>',
        "<a href='login.php'><li>Login</li></a>",
        $html
    );
}

echo $html;
?>
