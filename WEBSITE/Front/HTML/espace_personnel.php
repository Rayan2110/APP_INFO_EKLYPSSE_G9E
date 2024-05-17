<?php  
include 'header.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: admin.php"); // Redirigez vers la page de connexion
    exit();
}

// Vérifiez si les variables de session sont définies
if (!isset($_SESSION['pseudo'], $_SESSION['email'], $_SESSION['mdp'])) {
    echo "Variables de session non définies.";
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

// Traitement de la mise à jour des données de l'utilisateur
if(isset($_POST['submit'])) {
    // Récupérer les données envoyées par le formulaire
    $pseudo = $_POST['pseudo'];
    $nom = $_POST['nom'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];

    // Votre code pour mettre à jour les données de l'utilisateur dans la base de données
    $sql_update = "UPDATE users SET pseudo = '$pseudo', nom = '$nom', date_naissance = '$date_naissance', email = '$email' WHERE id = '$user_id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Changements enregistrés avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement des changements: " . $conn->error;
    }

    // Après avoir traité la mise à jour, vous pouvez rediriger l'utilisateur vers la même page pour afficher les changements mis à jour
    header("Location: espace_personnel.php");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}

// Récupérer les informations de l'utilisateur depuis la base de données
$user_id = $_SESSION['id']; // Assurez-vous d'avoir la colonne d'identifiant utilisateur appropriée
$sql = "SELECT pseudo, nom, date_naissance, email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Récupérer les données de l'utilisateur
    $row = $result->fetch_assoc();
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
    <?php
    // Afficher un message si des changements ont été enregistrés
    if(isset($_POST['submit'])) {
        echo "<p>Changements enregistrés avec succès.</p>";
    }
    ?>
    <form method="post" action="espace_personnel.php">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>">
        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $date_naissance; ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>">
        <label for="old_password">Ancien mot de passe:</label>
        <input type="password" id="old_password" name="old_password">
        <label for="new_password">Nouveau mot de passe:</label>
        <input type="password" id="new_password" name="new_password">
        <button type="submit" name="submit">Enregistrer les changements</button>
    </form>
</body>
</html>
