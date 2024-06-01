<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['capteurs']) && is_array($data['capteurs'])) {
    foreach ($data['capteurs'] as $capteur) {
        $x = $capteur['x_coordinate'];
        $y = $capteur['y_coordinate'];
        $sound_level = rand(50, 100);  // Niveau sonore aléatoire pour démonstration, remplacer par la valeur réelle

        $query = "INSERT INTO capteurs (carte_evenement_id, x_coordinate, y_coordinate, sound_level) 
                  VALUES (1, $x, $y, $sound_level)";
        $conn->query($query);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>
