<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo 'Session non valide.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = isset($_POST['receiver_id']) ? (int)$_POST['receiver_id'] : null;
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $current_user_id = $_SESSION['id'];

    if (!$receiver_id || $receiver_id == $current_user_id || empty($message)) {
        http_response_code(400);
        echo 'Données incorrectes.';
        exit();
    }

    try {
        $pdo = new PDO('mysql:host=db;dbname=espace_membres', 'root', '');

        // Enregistrer le message
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$current_user_id, $receiver_id, $message]);

        // Ajouter la conversation ouverte pour le destinataire
        $stmt = $pdo->prepare("SELECT open_conversations FROM users WHERE id = ?");
        $stmt->execute([$receiver_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $open_conversations = $result ? explode(',', $result['open_conversations']) : [];

        if (!in_array($current_user_id, $open_conversations)) {
            $open_conversations[] = $current_user_id;
            $open_conversations_str = implode(',', $open_conversations);

            $stmt = $pdo->prepare("UPDATE users SET open_conversations = ? WHERE id = ?");
            $stmt->execute([$open_conversations_str, $receiver_id]);
        }

        echo 'Message envoyé avec succès.';
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erreur lors de l\'envoi du message : ' . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo 'Méthode non autorisée.';
}
?>


