<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$evenement_id = isset($_GET['evenement_id']) ? intval($_GET['evenement_id']) : 0;

if ($evenement_id > 0) {
    $query = "SELECT c.id, c.x_coordinate, c.y_coordinate, s.sound_level 
              FROM capteurs c
              LEFT JOIN (
                  SELECT sensor_id, sound_level 
                  FROM sound_levels 
                  WHERE id IN (
                      SELECT MAX(id) 
                      FROM sound_levels 
                      GROUP BY sensor_id
                  )
              ) s ON c.id = s.sensor_id
              WHERE c.carte_evenement_id = (
                  SELECT id FROM cartes_evenements WHERE evenement_id = ?
              )";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $evenement_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $capteurs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $capteurs[] = $row;
        }
    }

    echo json_encode(['status' => 'success', 'capteurs' => $capteurs]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid event ID']);
}

$conn->close();
?>
