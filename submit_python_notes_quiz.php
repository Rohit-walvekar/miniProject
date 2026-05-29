<?php
session_start();
header('Content-Type: text/plain; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit();
}

if (!isset($_POST['score']) || !isset($_POST['total'])) {
    echo "error";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
$quiz_name = "Python Notes Quiz";
$score = intval($_POST['score']);
$total = intval($_POST['total']);

require_once 'db_connect.php';

if (!isset($conn) || !$conn) {
    echo "error";
    exit();
}

$stmt = $conn->prepare("SELECT COUNT(*) AS attempt_count FROM quiz_results WHERE user_id = ? AND quiz_name = ?");
if (!$stmt) {
    echo "error";
    exit();
}
$stmt->bind_param("is", $user_id, $quiz_name);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$attempts = isset($row['attempt_count']) ? intval($row['attempt_count']) : 0;
$stmt->close();

if ($attempts >= 3) {
    echo "limit_reached";
    exit();
}

$attempt_number = $attempts + 1;
$ins = $conn->prepare("INSERT INTO quiz_results (user_id, username, quiz_name, score, total, attempt_number) VALUES (?, ?, ?, ?, ?, ?)");
if (!$ins) {
    echo "error";
    exit();
}
$ins->bind_param("issiii", $user_id, $username, $quiz_name, $score, $total, $attempt_number);
$ok = $ins->execute();
$ins->close();

if ($ok) {
    echo "success";
} else {
    echo "error";
}
?>
