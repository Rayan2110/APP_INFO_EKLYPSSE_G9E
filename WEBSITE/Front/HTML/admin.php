<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Eklypsse</title>
</head>
<body>
<?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>
    <a href="admin.php" class="Admin" ><h1>Admin</h1></a>
    <br>
    <div class="Lien" >
        <button type="button" name="PublierArticle" class="PublierArticle" ><a href="publier-article.php">Publier une article</a></button>
        <button type="button" name="AfficherUser" class="AfficherUser" ><a href="afficher_utilisateur.php">Afficher les utilisateurs</a></button>
    </div>
</body>
</html>