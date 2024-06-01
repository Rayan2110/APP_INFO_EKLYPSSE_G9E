<?php
$host = 'db';
$dbname = 'espace_membres';
$user = 'root';
$password = '';

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données JSON depuis la requête
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        die(json_encode(['status' => 'error', 'message' => 'No data received']));
    }

    $sensor_id = isset($data['sensor_id']) ? $data['sensor_id'] : null;
    $sound_level = isset($data['sound_level']) ? $data['sound_level'] : null;

    if ($sensor_id === null || $sound_level === null) {
        die(json_encode(['status' => 'error', 'message' => 'Invalid data']));
    }

    // Requête préparée pour l'insertion des données
    $stmt = $bdd->prepare("INSERT INTO sound_levels (sensor_id, sound_level) VALUES (?, ?)");

    if (!$stmt) {
        die(json_encode(['status' => 'error', 'message' => $bdd->errorInfo()]));
    }

    // Liaison des valeurs et exécution de la requête
    if ($stmt->execute([$sensor_id, $sound_level])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->errorInfo()]);
    }

    // Fermeture du statement et de la connexion
    $stmt->closeCursor();
    $bdd = null;
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de requête
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
}
?>
