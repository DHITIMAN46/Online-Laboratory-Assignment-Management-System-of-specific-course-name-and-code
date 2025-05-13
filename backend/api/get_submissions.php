<?php
require '../config/db.php';
header("Content-Type: application/json");

if (isset($_GET['assignment_id'])) {
    $stmt = $conn->prepare("
        SELECT 
            submissions.id,
            submissions.user_id,
            users.name AS student_name,
            submissions.file_path,
            submissions.grade,
            submissions.feedback
        FROM submissions
        JOIN users ON submissions.user_id = users.id
        WHERE submissions.assignment_id = ?
    ");
    $stmt->execute([$_GET['assignment_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode(["error" => "Missing assignment_id"]);
}
?>
