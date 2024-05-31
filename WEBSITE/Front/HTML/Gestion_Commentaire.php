<?php
session_start();
if($_SESSION['pseudo'] !== "root"){
    header('Location: forbidden.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css"> 
    <title>Gestion des commentaires</title>

</head>
<body>
    <?php
        // Inclure le fichier header.php
        include 'header.php';
    ?>

    <main class="adminMain"> 
        <button class="retourBtn" ><a href="admin.php">Retour</a></button>
        <div class="gestionTitre">
            <a href="admin.php" class="Admin"><h1>Admin </h1></a> 
            <h2>/ Gestion des commentaires</h2>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Ajouter un commentaire</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <form method="POST" action="" class="hidden">
                <div class="champs">
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" id="pseudo" name="pseudo" >
                        </div>
                        <div class="ajoutChamp">
                            <label for="reference">Object</label>
                            <input type="text" id="reference" name="reference" >
                        </div>
                    </div>
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="date">Date de commission</label>
                            <input type="date" id="date" name="date" >
                        </div>
                    </div>
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="commentaire">Commentaire</label>
                            <textarea name="commentaire" id="commentaire"></textarea>
                        </div>
                    </div>
                </div>
                <input class="ajouterBtn" type="submit" name="envoie" value="Ajouter" >
                <br>
            </form>

            <?php
            // Traitement du formulaire
            if (isset($_POST['envoie'])) {  // Vérifier si le commentaire a été envoyé
                if (!empty($_POST['pseudo']) && !empty($_POST['reference']) && !empty($_POST['date']) && !empty($_POST['commentaire']) ) {
                    // Sécurisation des entrées
                    $pseudo = htmlspecialchars($_POST['pseudo']);
                    $reference = htmlspecialchars($_POST['reference']);
                    $date = htmlspecialchars($_POST['date']);
                    $commentaire = htmlspecialchars($_POST['commentaire']);

                    try {
                        // Préparation et exécution de la requête SQL
                        $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
                        $stmt = $bdd->prepare("INSERT INTO comments (pseudo, reference, date, commentaire) VALUES (?, ?, ?, ?)");
                        $stmt->execute(array($pseudo, $reference, $date, $commentaire));
                        echo "Le commentaire a été ajouté avec succès";
                    } catch (PDOException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                } 
            }
        ?>
        

        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Supprimer un commentaire</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <form method="POST" action="" class="hidden">
            <?php
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupération des événements depuis la base de données
                $requete = $bdd->query('SELECT id, pseudo, date, commentaire, reference FROM comments');

                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<div class ="choixCommentaire">';
                echo '<label for="id">Sélectionnez un commentaire à supprimer : </label>';
                echo '<select name="id_commentaire" id="id_commantaire">';

                while ($row = $requete->fetch()) {
                    echo '<option value="' . $row['id'] . '">' . $row['pseudo'] . ' - ' . $row['reference'] . ' - ' . $row['commentaire'] . ' - ' . $row['date'] . '</option>';
                }

                echo '</select>';
                echo '</div>';
                echo '<input class="ajouterBtn" name="supprimer" type="submit" value="Supprimer">';
                echo '<br>';
                echo '</form>';
            
                // Traitement de la suppression d'événement
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer'])) {
                    $id_commentaire_a_supprimer = $_POST['id_commentaire'];

                    // Suppression de l'événement sélectionné
                    $sql_suppression = "DELETE FROM comments WHERE id = $id_commentaire_a_supprimer";
                    $bdd->exec($sql_suppression);
                    echo "Le commentaire a été supprimé avec succès";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
            </form>
        </div>

        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Modifier un commentaire</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>

            <?php
                try {
                    $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $requete = $bdd->query('SELECT id, pseudo, date, commentaire, reference FROM comments');
                    $comments = $requete->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            ?>

            <form method="POST" action="" class="hidden">
                <div class="choixCommentaire">
                    <label for="id_commentaire_mod">Sélectionnez un commentaire à modifier : </label>
                    <select name="id_commentaire_mod" id="id_commentaire_mod">
                        <?php foreach ($comments as $comment) {
                            echo "<option value='{$comment['id']}'>{$comment['pseudo']} - {$comment['commentaire']} - {$comment['reference']}</option>";
                        } ?>
                    </select>
                </div>
                <button class= "ajouterBtn" type="button" onclick="loadCommentData()">Choisir</button>
                <br>
                <div id="commentDetails" style="display:none;">
                    <div class="champs">
                        <div class="champ1">
                            <div class="ajoutChamp">
                                <label for="pseudo">Pseudo</label>
                                <input type="text" id="pseudoM" name="pseudo">
                            </div>
                            <div class="ajoutChamp">
                                <label for="reference">Object</label>
                                <input type="text" id="referenceM" name="reference">
                            </div>
                        </div>
                        <div class="champ1">
                            <div class="ajoutChamp">
                                <label for="date">Date de commission</label>
                                <input type="date" id="dateM" name="date">
                            </div>
                        </div>
                        <div class="champ1">
                            <div class="ajoutChamp">
                                <label for="commentaire">Commentaire</label>
                                <textarea name="commentaire" id="commentaireM"></textarea>
                            </div>
                        </div>
                    </div>
                    <input class="ajouterBtn" type="submit" name="modifier" value="Modifier">
                </div>
                <br>
            </form>
            
            <script>
                function loadCommentData() {
                    var selectedIndex = document.getElementById('id_commentaire_mod').value;
                    var commentDetails = <?php echo json_encode($comments); ?>;
                    
                    var selectedComment = commentDetails.find(comment => comment.id == selectedIndex);
                    if (selectedComment) {
                        document.getElementById('pseudoM').value = selectedComment.pseudo;
                        document.getElementById('referenceM').value = selectedComment.reference;
                        document.getElementById('dateM').value = selectedComment.date;
                        document.getElementById('commentaireM').value = selectedComment.commentaire;
                        document.getElementById('commentDetails').style.display = 'block';
                    }
                }
            </script>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
                    $id = $_POST['id_commentaire_mod'];
                    $pseudo = htmlspecialchars($_POST['pseudo']);
                    $reference = htmlspecialchars($_POST['reference']);
                    $date = htmlspecialchars($_POST['date']);
                    $commentaire = htmlspecialchars($_POST['commentaire']);

                    try {
                        $stmt = $bdd->prepare("UPDATE comments SET pseudo = ?, reference = ?, date = ?, commentaire = ? WHERE id = ?");
                        $stmt->execute([$pseudo, $reference, $date, $commentaire, $id]);
                        echo "Le commentaire a été modifié avec succès";
                    } catch (PDOException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                }
            ?>

    </main>

    <br>
	<br>
	<br>
	
    <footer>
    <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
    </footer>

    <script>
    var sousTitres = document.querySelectorAll('.sousTitre');

    sousTitres.forEach(function(sousTitre) {
        sousTitre.addEventListener('click', function() {
            // Récupère le parent de la div sousTitre, c'est-à-dire la div ajoutContainer
            var ajoutContainer = this.parentElement;

            // Récupère tous les éléments enfants de la div ajoutContainer
            var elements = ajoutContainer.querySelectorAll(':scope > *');

            // Boucle à travers tous les éléments
            elements.forEach(function(element) {
                // Si l'élément n'est pas la div sousTitre elle-même
                if (!element.classList.contains('sousTitre')) {
                    // Basculer la classe hidden pour cacher ou afficher l'élément
                    element.classList.toggle('hidden');
                }
            });

            // Récupère l'élément i avec la classe fa-chevron-down
            var chevron = this.querySelector('.fa-chevron-down');

            // Basculer la rotation du chevron
            chevron.style.transform = chevron.style.transform === 'rotate(180deg)' ? 'rotate(0deg)' : 'rotate(180deg)';
        });
    });

</script>

</body>
</html>