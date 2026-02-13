<?php
header('Content-Type: application/json');
include 'db_connect.php';


$userCount = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM users");
if ($result && $row = $result->fetch_assoc()) {
    $userCount = $row['total'];
}

$feedbackCount = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM feedback");
if ($result && $row = $result->fetch_assoc()) {
    $feedbackCount = $row['total'];
}

$uploadCount = 0;
$check = $conn->query("SHOW TABLES LIKE 'uploads'");
if ($check && $check->num_rows > 0) {
    $res = $conn->query("SELECT COUNT(*) AS total FROM uploads");
    if ($res && $row = $res->fetch_assoc()) {
        $uploadCount = $row['total'];
    }
}

$activity = [];
$result = $conn->query("SELECT * FROM activity_log ORDER BY log_time DESC LIMIT 10");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $activity[] = $row;
    }
}

echo json_encode([
    'userCount' => $userCount,
    'feedbackCount' => $feedbackCount,
    'uploadCount' => $uploadCount,
    'activity' => $activity
]);

$conn->close();
?>
