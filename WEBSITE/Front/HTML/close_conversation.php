<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo 'Session non valide.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
    $current_user_id = $_SESSION['id'];

    if (!$user_id || $user_id == $current_user_id) {
        http_response_code(400);
        echo 'Données incorrectes.';
        exit();
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');

        // Récupérer les conversations ouvertes actuelles
        $stmt = $pdo->prepare("SELECT open_conversations FROM users WHERE id = ?");
        $stmt->execute([$current_user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $open_conversations = $result ? explode(',', $result['open_conversations']) : [];

        // Retirer la conversation fermée si elle est présente
        if (($key = array_search($user_id, $open_conversations)) !== false) {
            unset($open_conversations[$key]);
            $open_conversations_str = implode(',', $open_conversations);

            // Mettre à jour la base de données
            $stmt = $pdo->prepare("UPDATE users SET open_conversations = ? WHERE id = ?");
            $stmt->execute([$open_conversations_str, $current_user_id]);
        }

        echo 'Conversation fermée avec succès.';
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erreur lors de la fermeture de la conversation : ' . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo 'Méthode non autorisée.';
}
?>

