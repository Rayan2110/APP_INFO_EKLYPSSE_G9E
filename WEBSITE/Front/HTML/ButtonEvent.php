<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $localisation = $_POST['localisation'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $prix = $_POST['prix'];
    
    // Préparation et exécution de la requête SQL
    $stmt = $bdd->prepare("INSERT INTO evenements (nom, localisation, date_debut, date_fin, prix) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $localisation, $date_debut, $date_fin, $prix]);
    
    // Redirection après l'insertion
    header('Location: Evenement.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Événement</title>
    <link rel="stylesheet" href="ajouter_evenement.css"> 
    <script src="ajouter_evenement.js" defer></script>
</head>

<?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>

<body>
    <div class="container">
        <h1>Ajouter un nouvel événement</h1>
        <form method="post" action="ajouter_evenement.js">
            <label for="nom">Nom de l'événement:</label>
            <input type="text" id="nom" name="nom" required><br><br>
            <label for="localisation">Localisation:</label>
            <input type="text" id="localisation" name="localisation" required><br><br>
            <label for="date_debut">Date de début:</label>
            <input type="date" id="date_debut" name="date_debut" required><br><br>
            <label for="date_fin">Date de fin:</label>
            <input type="date" id="date_fin" name="date_fin" required><br><br>
            <label for="prix">Prix par jour (€):</label>
            <input type="number" id="prix" name="prix" required><br><br>
            <input type="submit" value="Ajouter l'événement">
        </form>
    </div>
</body>
</html>
