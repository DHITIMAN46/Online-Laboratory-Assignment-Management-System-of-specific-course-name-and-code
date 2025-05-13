<?php
require '../config/db.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'], $_POST['assignment_id'], $_POST['user_id'])) {
    $assignment_id = $_POST['assignment_id'];
    $user_id = $_POST['user_id'];
    $upload_dir = "../../uploads/";

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = basename($_FILES['file']['name']);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, user_id, file_path) VALUES (?, ?, ?)");
        $stmt->execute([$assignment_id, $user_id, $file_name]);
        echo json_encode(["success" => true, "message" => "File uploaded successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "File upload failed"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing form data"]);
}
?>