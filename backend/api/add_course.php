<?php
require '../config/db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['course_name'], $data['course_code'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO courses (course_name, course_code) VALUES (?, ?)");
        $stmt->execute([$data['course_name'], $data['course_code']]);
        echo json_encode(["success" => true, "message" => "Course added successfully"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
}
?>