<?php
require '../config/db.php';
header("Content-Type: application/json");

if (isset($_GET['user_id'])) {
    $stmt = $conn->prepare("
        SELECT 
            submissions.id AS submission_id,
            submissions.assignment_id,
            submissions.file_path,
            submissions.grade,
            submissions.feedback
        FROM submissions
        WHERE submissions.user_id = ?
    ");
    $stmt->execute([$_GET['user_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode(["error" => "Missing user_id"]);
}
?>
