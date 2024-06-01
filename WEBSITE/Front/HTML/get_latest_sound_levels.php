<?php
$host = 'db';
$dbname = 'espace_membres';
$user = 'root';
$password = '';

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        $stmt = $bdd->prepare($query);
        $stmt->execute([$evenement_id]);
        $capteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status' => 'success', 'capteurs' => $capteurs]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid event ID']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
}
?>
