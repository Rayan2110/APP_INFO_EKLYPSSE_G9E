<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo 'Session non valide.';
    exit();
}

try {
    $pdo = new PDO('mysql:host=db;dbname=espace_membres', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $current_user_id = $_SESSION['id'];

    // Récupérer les conversations ouvertes
    $stmt = $pdo->prepare("SELECT open_conversations FROM users WHERE id = ?");
    $stmt->execute([$current_user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $open_conversations = $result ? explode(',', $result['open_conversations']) : [];

    if (count($open_conversations) > 0) {
        $placeholders = str_repeat('?,', count($open_conversations) - 1) . '?';
        $sql = "SELECT id, pseudo FROM users WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($open_conversations);
        $recent_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Trier les utilisateurs selon l'ordre de $open_conversations
        usort($recent_users, function($a, $b) use ($open_conversations) {
            return array_search($a['id'], $open_conversations) - array_search($b['id'], $open_conversations);
        });
    } else {
        $recent_users = [];
    }

    foreach ($recent_users as $user) {
        echo '<button id="recentUser' . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') . '" class="raccourci" onclick="selectUser(\'' . htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8') . '\', ' . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') . ')">' . 
                htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8') . 
                '<span class="close" style="color:red; cursor:pointer;" onclick="event.stopPropagation(); closeConversation(' . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') . ')">&#10006;</span>' .
             '</button><br>';
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Erreur lors de la récupération des utilisateurs récents : ' . $e->getMessage();
}
?>