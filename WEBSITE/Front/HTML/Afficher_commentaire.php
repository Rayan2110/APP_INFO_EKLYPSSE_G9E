<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/commentaire.css">
</head>
<body>

<?php
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');

    // Déterminer la page actuelle
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Nombre de commentaires à afficher par page
    $comments_par_page = 4;

    // Calculer le point de départ pour la requête SQL
    $debut = ($page - 1) * $comments_par_page;

    // Requête pour récupérer les données depuis la base de données
    $requete = $bdd->prepare("SELECT pseudo, commentaire, date, reference FROM comments LIMIT :debut, :limite");
    $requete->bindParam(':debut', $debut, PDO::PARAM_INT);
    $requete->bindParam(':limite', $comments_par_page, PDO::PARAM_INT);
    $requete->execute();

    // Afficher les commentaires dans un encadré
    echo '<div class="commentaire">';
    while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="contenue">';
        echo '<strong>'. $row['pseudo'] . '</strong> ' . '<br>' . '<br>';
        echo '<strong>' . $row['reference'] . '</strong> ' . '<br>' . '<br>';
        echo '<strong>Commentaire:</strong> ' . '<br>' . '<br>' . $row['commentaire'] . '<br>' . '<br>';
        echo '<strong>Posté le : </strong> ' . $row['date'] . '<br>' . '<br>';
        echo '</div>';
    }
    echo '</div>';

    // Boutons pour la navigation entre les pages
    $requete_total = $bdd->query("SELECT COUNT(*) AS total FROM comments");
    $total = $requete_total->fetch(PDO::FETCH_ASSOC)['total'];
    $nombre_de_pages = ceil($total / $comments_par_page);

    echo '<div style="margin-top: 20px; display: flex; flex-direction: row;">';
    if ($page > 1) {
        echo '<a href="?page='.($page - 1).'" class="bouton-page bouton-precedent ">&lt;</a>'; // Bouton précédent avec symbole <
    }
    if ($page < $nombre_de_pages) {
        if ($page == 1) {
            echo '<a href="?page='.($page + 1).'" class="bouton-page bouton-suivant" style="margin-left: 73.3%;" >&gt;</a>';
        } else {
            echo '<a href="?page='.($page + 1).'" class="bouton-page bouton-suivant">&gt;</a>'; // Bouton suivant avec symbole >
        }
    }
    echo '</div>';

    // Fermer la connexion à la base de données
    $requete->closeCursor();
?>

</body>
</html>