<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['submission_id'], $data['grade'], $data['feedback'])) {
  echo json_encode(["error" => "Missing required fields"]);
  exit;
}

$submission_id = $data['submission_id'];
$grade = $data['grade'];
$feedback = $data['feedback'];

$conn = new mysqli("localhost", "root", "", "online_lab_system");

$stmt = $conn->prepare("UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?");
$stmt->bind_param("ssi", $grade, $feedback, $submission_id);

if ($stmt->execute()) {
  echo json_encode(["message" => "Grade submitted successfully"]);
} else {
  echo json_encode(["error" => "Failed to submit grade"]);
}

$stmt->close();
$conn->close();
?>
