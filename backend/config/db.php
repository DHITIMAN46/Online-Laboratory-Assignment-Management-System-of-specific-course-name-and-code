<?php
$host = "localhost";
$dbname = "online_lab_system";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB Connected"; ❌ remove this
} catch (PDOException $e) {
    die(json_encode(["error" => "Database connection failed: " . $e->getMessage()])); // ✅ if needed
}
?>
