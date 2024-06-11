<?php
ob_start();
include 'header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: connexion.php"); // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}
if ($_SESSION['pseudo'] === 'root') {
    header("Location: Home.php"); // Redirigez vers la page d'interdiction si l'utilisateur est root
    exit();
}

// Connexion à la base de données
$servername = "db";
$username = "root";
$password = "";
$dbname = "espace_membres";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupérer les informations de l'utilisateur depuis la base de données
$user_id = $_SESSION['id']; // Assurez-vous d'avoir la colonne d'identifiant utilisateur appropriée

// Modifiez ici si le champ password a un nom différent dans votre table
$sql = "SELECT pseudo, nom, date_naissance, email, mdp FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Récupérer les données de l'utilisateur
    $pseudo = $user['pseudo'];
    $nom = $user['nom'];
    $date_naissance = $user['date_naissance'];
    $email = $user['email'];
    $hashed_password = $user['mdp'];
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

    // Vérifier l'ancien mot de passe
    if (password_verify($old_password, $hashed_password)) {
        // Mettre à jour les données de l'utilisateur
        if (!empty($new_password)) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE users SET pseudo = :pseudo, nom = :nom, date_naissance = :date_naissance, email = :email, mdp = :mdp WHERE id = :id";
            $stmt = $conn->prepare($sql_update);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':date_naissance', $date_naissance);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mdp', $new_hashed_password);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        } else {
            $sql_update = "UPDATE users SET pseudo = :pseudo, nom = :nom, date_naissance = :date_naissance, email = :email WHERE id = :id";
            $stmt = $conn->prepare($sql_update);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':date_naissance', $date_naissance);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {
            echo "Changements enregistrés avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement des changements: " . $stmt->errorInfo()[2];
        }

        // Rediriger l'utilisateur vers la même page pour afficher les changements mis à jour
        header("Location: espace_personnel.php");
        exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
    } else {
        echo "L'ancien mot de passe est incorrect.";
    }
}

// Récupérer les billets de l'utilisateur depuis la base de données
$sql_billets = "SELECT e.nom, e.date_début, e.date_fin, e.localisation, e.prix 
                FROM billet b 
                JOIN evenements e ON b.id_evenements = e.id 
                WHERE b.id_users = :id_users";
$stmt_billets = $conn->prepare($sql_billets);
$stmt_billets->bindParam(':id_users', $user_id, PDO::PARAM_INT);
$stmt_billets->execute();
$billets = $stmt_billets->fetchAll(PDO::FETCH_ASSOC);

$conn = null; // Fermer la connexion à la base de données
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
    <h2>Espace Personnel</h2>
    <form method="post" action="espace_personnel.php">
        <div class="form-row">
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($pseudo); ?>">
        </div>
        <div class="form-row">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
        </div>
        <div class="form-row">
            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($date_naissance); ?>">
        </div>
        <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="form-row">
            <label for="old_password">Ancien mot de passe:</label>
            <input type="password" id="old_password" name="old_password">
        </div>
        <div class="form-row">
            <label for="new_password">Nouveau mot de passe:</label>
            <input type="password" id="new_password" name="new_password">
        </div>
        <button type="submit" name="submit">Enregistrer les changements</button>
    </form>
    <div class="billets-section">
    <h3>Mes Billets</h3>
    <?php if (!empty($billets)): ?>
        <ul>
            <?php foreach ($billets as $billet): ?>
                <li>
                    <strong><?php echo htmlspecialchars($billet['nom']); ?></strong> - 
                    Date début: <?php echo htmlspecialchars($billet['date_début']); ?> - 
                    Date fin: <?php echo htmlspecialchars($billet['date_fin']); ?> - 
                    Localisation: <?php echo htmlspecialchars($billet['localisation']); ?> - 
                    Prix: <?php echo htmlspecialchars($billet['prix']); ?> €
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun billet trouvé.</p>
    <?php endif; ?>
</div>

     <form method="post" action="deconnexion.php">
        <button type="submit">Déconnexion</button>
</form>
</body>
<footer>
    <?php include 'footer.php';?>
</footer>
</html>

<?php
ob_end_flush();
?>
