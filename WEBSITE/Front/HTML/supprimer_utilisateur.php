<?php

// Vérifie si le formulaire de suppression a été soumis
if (isset($_POST['submit'])) {
    // Récupère les données du formulaire
    $pseudo = $_POST['pseudo'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    // Validation des données (vous pouvez ajouter des validations supplémentaires ici si nécessaire)

    // Connexion à la base de données
    $bdd = new PDO('mysql:host=db;dbname=espace_membres', 'root', '');

    // Requête SQL pour supprimer l'utilisateur
    $requete = "DELETE FROM users WHERE pseudo = :pseudo AND nom = :nom AND email = :email";
    $statement = $bdd->prepare($requete);
    $statement->bindParam(':pseudo', $pseudo);
    $statement->bindParam(':nom', $nom);
    $statement->bindParam(':email', $email);

    // Exécute la requête
    if ($statement->execute()) {
        echo "Utilisateur supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }

    // Fermer la connexion
    $bdd = null;
} else {
    // Redirection si le formulaire n'a pas été soumis
    header("Location: index.php"); // Remplacez index.php par le chemin de votre page principale
    exit();
}

?>
