<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    die(json_encode(['status' => 'error', 'message' => 'No data received']));
}

$sensor_id = isset($data['sensor_id']) ? $data['sensor_id'] : null;
$sound_level = isset($data['sound_level']) ? $data['sound_level'] : null;

if ($sensor_id === null || $sound_level === null) {
    die(json_encode(['status' => 'error', 'message' => 'Invalid data']));
}

$stmt = $conn->prepare("INSERT INTO sound_levels (sensor_id, sound_level) VALUES (?, ?)");
if (!$stmt) {
    die(json_encode(['status' => 'error', 'message' => $conn->error]));
}

$stmt->bind_param("id", $sensor_id, $sound_level);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
