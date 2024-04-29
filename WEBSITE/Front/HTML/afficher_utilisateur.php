<?php

// Fonction pour afficher la liste des utilisateurs
function afficherUtilisateurs() {
    // Connexion à la base de données
    
    // Connexion
    $bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');
    
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
    echo "</tr>";
    
    // Affichage des utilisateurs
    while ($ligne = $resultat->fetch()) {
        echo "<tr>";
        echo "<td>" . $ligne["pseudo"] . "</td>";
        echo "<td>" . $ligne["nom"] . "</td>";
        echo "<td>" . $ligne["email"] . "</td>";
        echo "<td>" . $ligne["date_naissance"] . "</td>";
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
