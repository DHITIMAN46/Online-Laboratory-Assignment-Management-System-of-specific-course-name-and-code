<?php
require '../config/db.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (
    isset($data['name'], $data['email'], $data['password'], $data['role'], $data['course_name'], $data['course_code'])
) {
    $name = $data['name'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $role = $data['role'];
    $course_name = $data['course_name'];
    $course_code = $data['course_code'];

    try {
        // Check or create course
        $stmt = $conn->prepare("SELECT id FROM courses WHERE course_name = ? AND course_code = ?");
        $stmt->execute([$course_name, $course_code]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($course) {
            $course_id = $course['id'];
        } else {
            $stmt = $conn->prepare("INSERT INTO courses (course_name, course_code) VALUES (?, ?)");
            $stmt->execute([$course_name, $course_code]);
            $course_id = $conn->lastInsertId();
        }

        // Register user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, course_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role, $course_id]);

        echo json_encode(["success" => true, "message" => "Registered successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "All fields required."]);
}
?>