<?php
require '../config/db.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['course_id'], $data['title'], $data['description'], $data['deadline'])) {
    $stmt = $conn->prepare("INSERT INTO assignments (course_id, title, description, deadline) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['course_id'], $data['title'], $data['description'], $data['deadline']]);
    echo json_encode(["success" => true, "message" => "Assignment created successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Missing input data"]);
}
?>