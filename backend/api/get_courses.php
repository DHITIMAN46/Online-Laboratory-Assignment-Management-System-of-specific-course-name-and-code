<?php
require '../config/db.php';
$stmt = $conn->query("SELECT * FROM courses");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
