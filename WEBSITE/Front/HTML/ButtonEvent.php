<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Événement</title>
    <link rel="stylesheet" href=""> 
</head>

<?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>

<body>
    <div class="container">
        <h1>Ajouter un nouvel événement</h1>
        <form method="POST" action="">
            <label for="nom">Nom de l'événement:</label>
            <input type="text" id="nom" name="nom" ><br><br>
            <label for="localisation">Localisation:</label>
            <input type="text" id="localisation" name="localisation" ><br><br>
            <label for="date_début">Date de début:</label>
            <input type="date" id="date_début" name="date_début" ><br><br>
            <label for="date_fin">Date de fin:</label>
            <input type="date" id="date_fin" name="date_fin" ><br><br>
            <label for="prix">Prix par jour (€):</label>
            <input type="number" id="prix" name="prix" ><br><br>
            <input type="submit" name="envoi" value="Ajouter l'événement" >
        </form>
    </div>
   <!-- <script src="ajouter_evenement.js" defer></script> -->
</body>
</html>


<?php

// Traitement du formulaire
if (isset($_POST['envoi'])) {  // Vérifier si le formulaire a été envoyé
    if (!empty($_POST['nom']) && !empty($_POST['localisation']) && !empty($_POST['date_début']) && !empty($_POST['date_fin']) && !empty($_POST['prix'])) {
        // Sécurisation des entrées
        $nom = htmlspecialchars($_POST['nom']);
        $localisation = htmlspecialchars($_POST['localisation']);
        $date_debut = htmlspecialchars($_POST['date_début']);
        $date_fin = htmlspecialchars($_POST['date_fin']);
        $prix = htmlspecialchars($_POST['prix']);

        try {
            // Préparation et exécution de la requête SQL
            $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
            $stmt = $bdd->prepare("INSERT INTO evenements (nom, localisation, date_début, date_fin, prix) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(array($nom, $localisation, $date_debut, $date_fin, $prix));
            
            // Redirection après l'insertion
            header('Location: Evenement.php');
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } 
}
?>
