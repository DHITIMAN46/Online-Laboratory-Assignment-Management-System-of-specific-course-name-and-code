<?php
require '../config/db.php';

header("Content-Type: application/json");

$query = "
SELECT 
    users.name AS student_name,
    assignments.title AS assignment_title,
    courses.course_name,
    COALESCE(submissions.grade, 'Not Graded') AS grade
FROM submissions
JOIN users ON submissions.user_id = users.id
JOIN assignments ON submissions.assignment_id = assignments.id
JOIN courses ON assignments.course_id = courses.id
";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}