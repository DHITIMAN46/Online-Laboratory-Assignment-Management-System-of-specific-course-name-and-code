<?php
require '../config/db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['submission_id'], $data['grade'], $data['feedback'])) {
    $submission_id = $data['submission_id'];
    $grade = $data['grade'];
    $feedback = $data['feedback'];

    $stmt = $conn->prepare("UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?");
    $stmt->execute([$grade, $feedback, $submission_id]);

    echo json_encode(["success" => true, "message" => "Grade and Feedback updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
}
?>
