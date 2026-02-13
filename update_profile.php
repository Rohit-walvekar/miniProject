<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$full_name = $_POST['fullname'];
$address = $_POST['address'];
$mobile = $_POST['mobile'];

$update = $conn->prepare("UPDATE users SET full_name=?, address=?, mobile=? WHERE id=?");
$update->bind_param("sssi", $full_name, $address, $mobile, $user_id);

if ($update->execute()) {
    header("Location: profile.php?updated=1");
} else {
    echo "Error updating profile!";
}
?>
