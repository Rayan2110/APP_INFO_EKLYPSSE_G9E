<?php  

include 'header.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: connexion.php"); // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Connexion à la base de données avec PDO
try {
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
    // Configurez PDO pour qu'il lance des exceptions en cas d'erreur
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Récupérer les informations de l'utilisateur depuis la base de données
$user_id = $_SESSION['id']; // Assurez-vous d'avoir la colonne d'identifiant utilisateur appropriée
$sql = "SELECT pseudo, nom, date_naissance, email FROM users WHERE id = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Récupérer les données de l'utilisateur
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $pseudo = $row['pseudo'];
    $nom = $row['nom'];
    $date_naissance = $row['date_naissance'];
    $email = $row['email'];
} else {
    echo "Utilisateur non trouvé.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel</title>
</head>
<body>
    <h2>Espace Personnel</h2>
    <form method="post" action="update_user.php">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>">
        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $date_naissance; ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>">
        <label for="mdp">Mot de passe:</label>
        <input type="password" id="mdp" name="mdp" value="<?php echo $_SESSION['mdp']; ?>" readonly>
        <button type="submit" name="submit">Enregistrer les changements</button>
    </form>
</body>
</html>
