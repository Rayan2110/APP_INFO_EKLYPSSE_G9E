<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $capteur_id = $conn->real_escape_string($data['id']);

        $delete_query = "DELETE FROM capteurs WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param('i', $capteur_id);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
