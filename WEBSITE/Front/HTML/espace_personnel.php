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

    // Vérifier l'ancien mot de passe
    if (password_verify($old_password, $hashed_password)) {
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
        echo "L'ancien mot de passe est incorrect.";
    }
}

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
<body>
    <h2>Espace Personnel</h2>
    <form method="post" action="espace_personnel.php">
        <label for="pseudo">Pseudo:</label><br>
        <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($pseudo); ?>"><br>
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>"><br>
        <label for="date_naissance">Date de naissance:</label><br>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($date_naissance); ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>
        <label for="old_password">Ancien mot de passe:</label><br>
        <input type="password" id="old_password" name="old_password"><br>
        <label for="new_password">Nouveau mot de passe:</label><br>
        <input type="password" id="new_password" name="new_password"><br>
        <button type="submit" name="submit">Enregistrer les changements</button><br>
    </form>
</body>
</html>
