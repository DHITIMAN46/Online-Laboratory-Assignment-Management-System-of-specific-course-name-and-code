<?php
require '../config/db.php';
header("Content-Type: application/json");

if (isset($_GET['course_id'], $_GET['user_id'])) {
    $course_id = $_GET['course_id'];
    $user_id = $_GET['user_id'];

    $stmt = $conn->prepare("
        SELECT a.*, s.file_path, s.grade, s.feedback
        FROM assignments a
        LEFT JOIN submissions s ON a.id = s.assignment_id AND s.user_id = ?
        WHERE a.course_id = ?
        ORDER BY a.deadline ASC
    ");
    $stmt->execute([$user_id, $course_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode(["error" => "Missing course_id or user_id"]);
}
?>
