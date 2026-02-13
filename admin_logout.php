<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
    logActivity($conn, $_SESSION['admin_id'], $_SESSION['username'], 'Admin logged out', true);
}

$conn->query("TRUNCATE TABLE activity_log");

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
