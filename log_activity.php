<?php
function logActivity($conn, $user_id, $username, $action, $isAdmin = false) {
    if ($isAdmin) {
        $sql = "INSERT INTO activity_log (user_id, username, action)
                VALUES (NULL, '$username', '$action')";
    } else {
        $sql = "INSERT INTO activity_log (user_id, username, action)
                VALUES ('$user_id', '$username', '$action')";
    }

    if (!$conn->query($sql)) {
        error_log("Activity log failed: " . $conn->error);
    }
}
?>
