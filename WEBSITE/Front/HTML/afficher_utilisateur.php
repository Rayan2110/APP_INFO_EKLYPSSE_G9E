<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Document</title>
</head>
<body>
<?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>
    <a href="admin.php" class="Admin" ><h1>Admin</h1></a>
    <br>
   
    
    <?php
    // Fonction pour afficher la liste des utilisateurs
    function afficherUtilisateurs() {
        // Connexion à la base de données

        // Connexion
        $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');

        $requete = "SELECT * FROM users";
        $resultat = $bdd->query($requete);

        // Début du tableau
        echo "<table border='1'>";

        // Entêtes du tableau
        echo "<tr>";
        echo "<th>Pseudo</th>";
        echo "<th>Nom</th>";
        echo "<th>Email</th>";
        echo "<th>Date de Naissance</th>";
        echo "<th>Suppression du compte</th>";
        echo "</tr>";

        // Affichage des utilisateurs
        while ($ligne = $resultat->fetch()) {
            echo "<tr>";
            echo "<td>" . $ligne["pseudo"] . "</td>";
            echo "<td>" . $ligne["nom"] . "</td>";
            echo "<td>" . $ligne["email"] . "</td>";
            echo "<td>" . $ligne["date_naissance"] . "</td>";
            // Colonnes pour la suppression
            echo "<td style='text-align: center; vertical-align: middle;'>";
            // Formulaire de suppression
            echo "<form method='post' action='supprimer_utilisateur.php'>";
            echo "<input type='hidden' name='pseudo' value='" . $ligne["pseudo"] . "'>";
            echo "<input type='hidden' name='nom' value='" . $ligne["nom"] . "'>";
            echo "<input type='hidden' name='email' value='" . $ligne["email"] . "'>";
            echo "<button type='submit' name='submit'>Supprimer</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        // Fin du tableau
        echo "</table>";

        // Fermer la connexion
        //$bdd->close();
    }

    // Appeler la fonction pour afficher les utilisateurs
    afficherUtilisateurs();
    ?>

</body>
<footer>
    <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
    </footer>
</html>