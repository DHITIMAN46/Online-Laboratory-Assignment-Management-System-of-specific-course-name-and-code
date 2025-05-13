<?php
require '../config/db.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'], $data['password'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($data['password'], $user['password'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "user_id" => $user['id'],
            "role" => $user['role'],
            "course_id" => $user['course_id']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid email or password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email and password required"]);
}
?>
