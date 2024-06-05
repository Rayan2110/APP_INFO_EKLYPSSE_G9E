

<?php
include 'header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: connexion.php"); // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les informations de l'utilisateur depuis la base de données
$user_id = $_SESSION['id']; // Assurez-vous d'avoir la colonne d'identifiant utilisateur appropriée

// Modifiez ici si le champ password a un nom différent dans votre table
$sql = "SELECT pseudo, nom, date_naissance, email, mdp FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Récupérer les données de l'utilisateur
    $row = $result->fetch_assoc();
    $pseudo = $row['pseudo'];
    $nom = $row['nom'];
    $date_naissance = $row['date_naissance'];
    $email = $row['email'];
    $hashed_password = $row['mdp'];
} else {
    echo "Utilisateur non trouvé.";
    exit();
}

// Traitement de la mise à jour des données de l'utilisateur
if (isset($_POST['submit'])) {
    // Récupérer les données envoyées par le formulaire
    $pseudo = $_POST['pseudo'];
    $nom = $_POST['nom'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier l'ancien mot de passe
    if (password_verify($old_password, $hashed_password)) {
        // Vérifier si le nouveau mot de passe et la confirmation correspondent
        if ($new_password === $confirm_password) {
            // Mettre à jour les données de l'utilisateur
            if (!empty($new_password)) {
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update = "UPDATE users SET pseudo = ?, nom = ?, date_naissance = ?, email = ?, mdp = ? WHERE id = ?";
                $stmt = $conn->prepare($sql_update);
                $stmt->bind_param("sssssi", $pseudo, $nom, $date_naissance, $email, $new_hashed_password, $user_id);
            } else {
                $sql_update = "UPDATE users SET pseudo = ?, nom = ?, date_naissance = ?, email = ? WHERE id = ?";
                $stmt = $conn->prepare($sql_update);
                $stmt->bind_param("ssssi", $pseudo, $nom, $date_naissance, $email, $user_id);
            }

            if ($stmt->execute()) {
                echo "Changements enregistrés avec succès.";
            } else {
                echo "Erreur lors de l'enregistrement des changements: " . $stmt->error;
            }

            $stmt->close();

            // Rediriger l'utilisateur vers la même page pour afficher les changements mis à jour
            header("Location: espace_personnel.php");
            exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
        } else {
            echo "Le nouveau mot de passe et la confirmation ne correspondent pas.";
        }
    } else {
        echo "L'ancien mot de passe est incorrect.";
    }
}

// Récupérer les billets de l'utilisateur depuis la base de données
$sql_billets = "SELECT e.nom, e.date_début, e.date_fin, e.localisation, e.prix 
                FROM billet b 
                JOIN evenements e ON b.id_evenements = e.id 
                WHERE b.id_users = ?";
$stmt_billets = $conn->prepare($sql_billets);
$stmt_billets->bind_param("i", $user_id);
$stmt_billets->execute();
$result_billets = $stmt_billets->get_result();
$billets = [];
if ($result_billets->num_rows > 0) {
    while ($row_billet = $result_billets->fetch_assoc()) {
        $billets[] = $row_billet;
    }
} else {
    echo "Aucun billet trouvé pour cet utilisateur.";
}
$stmt_billets->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/espace_personnel.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel</title>
</head>
<body class="espBody">
    <main class="adminMain"> 
        <div class="gestionTitre">
            <h1>Espace Personnel</h1>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Modifier les informations personnelles</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <form method="post" action="espace_personnel.php" class="hidden" onsubmit="return confirmChanges()">
                <div class="champs">
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="pseudo">Pseudo:</label>
                            <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($pseudo); ?>">
                        </div>
                        <div class="ajoutChamp">
                            <label for="nom">Nom:</label>
                            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
                        </div>
                    </div>
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="date_naissance">Date de naissance:</label>
                            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($date_naissance); ?>">
                        </div>
                        <div class="ajoutChamp">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                    </div>
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="old_password">Ancien mot de passe:</label>
                            <input type="password" id="old_password" name="old_password">
                        </div>
                        <div class="ajoutChamp">
                            <label for="new_password">Nouveau mot de passe:</label>
                            <input type="password" id="new_password" name="new_password">
                        </div>
                        <div class="ajoutChamp">
                            <label for="confirm_password">Confirmer le nouveau mot de passe:</label>
                            <input type="password" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                </div>
                <input class="ajouterBtn" type="submit" name="submit" value="Enregistrer les changements">
                <br>
            </form>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Mes Billets</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <div>
                <ul>
                    <?php if (!empty($billets)): ?>
                        <?php foreach ($billets as $billet): ?>
                            <div class="billet">
                                <li>
                                    <strong><?php echo htmlspecialchars($billet['nom']); ?></strong> - 
                                    Date début: <?php echo htmlspecialchars($billet['date_début']); ?> - 
                                    Date fin: <?php echo htmlspecialchars($billet['date_fin']); ?> - 
                                    Localisation: <?php echo htmlspecialchars($billet['localisation']); ?> - 
                                    Prix: <?php echo htmlspecialchars($billet['prix']); ?> €
                                </li>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun billet trouvé.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>

    <script>
        function confirmChanges() {
            return confirm("Êtes-vous sûr de vouloir enregistrer ces changements?");
        }

        var sousTitres = document.querySelectorAll('.sousTitre');

        sousTitres.forEach(function(sousTitre) {
            sousTitre.addEventListener('click', function() {
                // Récupère le parent de la div sousTitre, c'est-à-dire la div ajoutContainer
                var ajoutContainer = this.parentElement;

                // Récupère tous les éléments enfants de la div ajoutContainer
                var elements = ajoutContainer.querySelectorAll(':scope > *');

                // Boucle à travers tous les éléments
                elements.forEach(function(element) {
                    // Si l'élément n'est pas la div sousTitre elle-même
                    if (!element.classList.contains('sousTitre')) {
                        // Basculer la classe hidden pour cacher ou afficher l'élément
                        element.classList.toggle('hidden');
                    }
                });

                // Récupère l'élément i avec la classe fa-chevron-down
                var chevron = this.querySelector('.fa-chevron-down');

                // Basculer la rotation du chevron
                chevron.style.transform = chevron.style.transform === 'rotate(180deg)' ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        });
    </script>
</body>
</html>
