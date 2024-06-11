<?php
session_start();
include 'header.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$pdo = new PDO('mysql:host=db;dbname=espace_membres', 'root', '');

// Fonction pour récupérer les utilisateurs sauf l'utilisateur connecté
function getUsersExcludingCurrent($pdo, $current_user_id) {
    $stmt = $pdo->prepare("SELECT id, pseudo FROM users WHERE id != ?");
    $stmt->execute([$current_user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les derniers utilisateurs avec lesquels l'utilisateur a discuté
function getRecentUsers($pdo, $current_user_id) {
    $stmt = $pdo->prepare("SELECT open_conversations FROM users WHERE id = ?");
    $stmt->execute([$current_user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $open_conversations = $result ? explode(',', $result['open_conversations']) : [];

    if (count($open_conversations) > 0) {
        $placeholders = str_repeat('?,', count($open_conversations) - 1) . '?';
        $sql = "SELECT id, pseudo FROM users WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($open_conversations);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Trier les utilisateurs selon l'ordre de $open_conversations
        usort($users, function($a, $b) use ($open_conversations) {
            return array_search($a['id'], $open_conversations) - array_search($b['id'], $open_conversations);
        });

        return $users;
    } else {
        return [];
    }
}

// Fonction pour récupérer le pseudo d'un utilisateur par son ID
function getUserPseudo($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT pseudo FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? $user['pseudo'] : '';
}

$current_user_id = $_SESSION['id'];
$other_user_id = isset($_POST['receiver_id']) ? (int)$_POST['receiver_id'] : null;
$other_user_pseudo = '';

if ($other_user_id !== null && $other_user_id != 0) {
    $other_user_pseudo = getUserPseudo($pdo, $other_user_id);
} elseif (isset($_GET['receiver_id'])) {
    $other_user_id = (int)$_GET['receiver_id'];
    if ($other_user_id != 0) {
        $other_user_pseudo = getUserPseudo($pdo, $other_user_id);
    }
}

$other_user_id_safe = $other_user_id !== null ? htmlspecialchars($other_user_id, ENT_QUOTES, 'UTF-8') : '';

$users = getUsersExcludingCurrent($pdo, $current_user_id);
$recent_users = getRecentUsers($pdo, $current_user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../CSS/inbox.css?id=2">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat privé</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="container">
    <main>
        <div class="row">
            <div class="column" style="width: 20%;">
                <form id="userSelectForm" method="POST">
                    <input class="recherche" type="text" id="receiverIdInput" placeholder="Rechercher un utilisateur" onkeyup="filterUsers()">
                    <select id="userSelect" size="5" onchange="selectUser(this.options[this.selectedIndex].text, this.value)" style="width: 100%; margin-left: 10px; height: auto;">
                        <option value="">Sélectionner un utilisateur</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="receiver_id" id="hiddenReceiverIdInput" value="<?= $other_user_id_safe ?>">
                </form>
                <h3 style="align-self: center;">Conversations récentes</h3>
                <div id="recentUsers">
                    <?php foreach ($recent_users as $user): ?>
                        <button id="recentUser<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>" class="raccourci" onclick="selectUser('<?= htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8') ?>', <?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>)">
                            <?= htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8') ?> 
                            <span class="close" style="color:red; cursor:pointer;" onclick="event.stopPropagation(); closeConversation(<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>)">&#10006;</span>
                        </button><br>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="column" style="width: 70%; margin-left: 30px;">
                <h1 id="chatTitle">Chat privé<?= !empty($other_user_pseudo) ? ' avec ' . htmlspecialchars($other_user_pseudo, ENT_QUOTES, 'UTF-8') : '' ?></h1>
                <div id="conversation" class="conversation-container"></div>
                <div id="messageFormContainer">
                    <?php if ($other_user_id !== null && $other_user_id != 0): ?>
                    <form id="messageForm" onsubmit="return sendMessage();">
                        <input type="hidden" name="receiver_id" id="hiddenReceiverIdInput" value="<?= $other_user_id_safe ?>">
                        <input type="text" name="message" id="messageInput" placeholder="Saisissez votre message...">
                        <button class="envoyer" type="submit">Envoyer</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        function filterUsers() {
            var input = document.getElementById('receiverIdInput').value.toLowerCase();
            var select = document.getElementById('userSelect');
            var options = select.getElementsByTagName('option');

            if (input.length > 0) {
                select.style.display = 'block';
            } else {
                select.style.display = 'none';
            }

            for (var i = 0; i < options.length; i++) {
                var option = options[i];
                var text = option.text.toLowerCase();
                if (text.includes(input)) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                }
            }
        }

        function selectUser(userName, userId) {
            document.getElementById('receiverIdInput').value = userName;
            document.getElementById('hiddenReceiverIdInput').value = userId;
            document.getElementById('userSelect').style.display = 'none';
            openConversation(userId); // Ouvrir la conversation
            loadMessages(userId);
            updateChatTitle(userName); // Mettre à jour le titre
            showMessageForm(userId); // Afficher le formulaire de message
            setActiveButton(userId); // Mettre à jour l'apparence du bouton actif
        }

        function openConversation(userId) {
            $.post('open_conversation.php', { user_id: userId })
                .done(function(data) {
                    setActiveButton(userId); // Mettre à jour l'apparence du bouton actif après l'ouverture de la conversation
                    loadRecentUsers(); // Actualiser les conversations récentes
                })
                .fail(function() {
                    alert('Erreur lors de l\'ouverture de la conversation.');
                });
        }

        function closeConversation(userId) {
            $.post('close_conversation.php', { user_id: userId })
                .done(function(data) {
                    document.getElementById('recentUser' + userId).remove();
                    loadRecentUsers(); // Recharger la liste des utilisateurs récents pour réaligner les boutons
                })
                .fail(function() {
                    alert('Erreur lors de la fermeture de la conversation.');
                });
        }

        function updateButtonSpacing() {
            var buttons = document.querySelectorAll('#recentUsers .raccourci');
            buttons.forEach(button => button.style.marginBottom = '10px');
        }

        function validateMessage() {
            var message = document.getElementById('messageInput').value.trim();
            return message !== '';
        }

        function sendMessage() {
            if (!validateMessage()) {
                return false;
            }

            var receiverId = $('#hiddenReceiverIdInput').val();
            var message = $('#messageInput').val();

            $.post('send_messages.php', {
                receiver_id: receiverId,
                message: message
            }).done(function(data) {
                $('#messageInput').val('');
                loadMessages(receiverId);
                loadRecentUsers();
            }).fail(function(xhr, status, error) {
                alert('Erreur lors de l\'envoi du message : ' + xhr.responseText);
            });

            return false;
        }

        function loadMessages(receiverId) {
            var oldHeight = $('#conversation')[0].scrollHeight;
            $.get('get_messages.php', { receiver_id: receiverId })
                .done(function(data) {
                    $('#conversation').html(data);
                    var newHeight = $('#conversation')[0].scrollHeight;
                    if (newHeight > oldHeight) {
                        scrollConversationToBottom();
                    }
                })
                .fail(function() {
                    alert('Erreur lors du chargement des messages.');
                });
        }

        function scrollConversationToBottom() {
            var conversation = document.getElementById('conversation');
            conversation.scrollTop = conversation.scrollHeight;
        }

        function loadRecentUsers() {
            $.get('get_recent_users.php')
                .done(function(data) {
                    $('#recentUsers').html(data);
                    updateButtonSpacing();
                    setActiveButton(document.getElementById('hiddenReceiverIdInput').value); // Restaurer le bouton actif après le rechargement
                })
                .fail(function() {
                    alert('Erreur lors de la récupération des utilisateurs récents.');
                });
        }

        function updateChatTitle(userName) {
            var chatTitle = 'Chat privé avec ' + userName;
            $('#chatTitle').text(chatTitle);
        }

        function showMessageForm(userId) {
            var messageFormHtml = `
                <form id="messageForm" onsubmit="return sendMessage();">
                    <input type="hidden" name="receiver_id" id="hiddenReceiverIdInput" value="${userId}">
                    <input type="text" name="message" id="messageInput" placeholder="Saisissez votre message...">
                    <button class="envoyer" type="submit">Envoyer</button>
                </form>`;
            $('#messageFormContainer').html(messageFormHtml);
        }

        function setActiveButton(userId) {
            // Supprimer la classe active de tous les boutons
            var buttons = document.querySelectorAll('#recentUsers .raccourci');
            buttons.forEach(button => button.classList.remove('active'));
            
            // Ajouter la classe active au bouton sélectionné
            var activeButton = document.getElementById('recentUser' + userId);
            if (activeButton) {
                activeButton.classList.add('active');
            }
        }

        $(document).ready(function() {
            var receiverId = $('#hiddenReceiverIdInput').val();
            if (receiverId) {
                loadMessages(receiverId);
                setActiveButton(receiverId); // Mettre à jour l'apparence du bouton actif au chargement
            }
            loadRecentUsers();
        });
    </script>
</body>
</html>