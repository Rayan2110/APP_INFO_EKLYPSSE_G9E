<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo 'Session non valide.';
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $current_user_id = $_SESSION['id'];
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($user_id) {
        // Récupérer les conversations ouvertes
        $stmt = $pdo->prepare("SELECT open_conversations FROM users WHERE id = ?");
        $stmt->execute([$current_user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $open_conversations = $result ? explode(',', $result['open_conversations']) : [];

        // Mettre à jour la liste des conversations ouvertes
        $open_conversations = array_diff($open_conversations, [$user_id]);
        array_unshift($open_conversations, $user_id);

        $updated_open_conversations = implode(',', $open_conversations);
        $stmt = $pdo->prepare("UPDATE users SET open_conversations = ? WHERE id = ?");
        $stmt->execute([$updated_open_conversations, $current_user_id]);

        echo 'Success';
    } else {
        http_response_code(400);
        echo 'Invalid user ID.';
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Erreur lors de la mise à jour des conversations : ' . $e->getMessage();
}
?>
