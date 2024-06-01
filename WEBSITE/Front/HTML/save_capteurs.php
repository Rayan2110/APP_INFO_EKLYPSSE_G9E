<?php
$servername = "db";
$username = "root";
$password = "";
$dbname = "espace_membres";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO à exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['capteurs']) && is_array($data['capteurs'])) {
        foreach ($data['capteurs'] as $capteur) {
            $x = $capteur['x_coordinate'];
            $y = $capteur['y_coordinate'];
            $sound_level = rand(50, 100);  // Niveau sonore aléatoire pour démonstration, remplacer par la valeur réelle

            $stmt = $conn->prepare("INSERT INTO capteurs (carte_evenement_id, x_coordinate, y_coordinate, sound_level) 
                                    VALUES (1, :x, :y, :sound_level)");
            $stmt->bindParam(':x', $x);
            $stmt->bindParam(':y', $y);
            $stmt->bindParam(':sound_level', $sound_level);
            $stmt->execute();
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }
} catch(PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
}
?>
