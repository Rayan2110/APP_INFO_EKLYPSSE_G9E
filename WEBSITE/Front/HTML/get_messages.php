<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo 'Session non valide.';
    exit();
}

$pdo = new PDO('mysql:host=db;dbname=espace_membres', 'root', '');

$current_user_id = $_SESSION['id'];
$other_user_id = isset($_GET['receiver_id']) ? (int)$_GET['receiver_id'] : null;

if ($other_user_id && $other_user_id != $current_user_id) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC");
    $stmt->execute([$current_user_id, $other_user_id, $other_user_id, $current_user_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $message) {
        $date = date('d/m/Y H:i:s', strtotime($message['timestamp']));
        echo '<div class="message ' . ($message['sender_id'] == $_SESSION['id'] ? 'sent' : 'received') . '">';
        echo htmlspecialchars($message['message'], ENT_QUOTES, 'UTF-8');
        echo '<div class="date">' . $date . '</div>';
        echo '</div>';
    }
} else {
    echo '<p>Aucun message pour le moment.</p>';
}
?>



