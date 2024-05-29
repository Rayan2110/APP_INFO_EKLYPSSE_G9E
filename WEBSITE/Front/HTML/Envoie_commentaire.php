<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/pages.css">
    <link rel="stylesheet" href="../CSS/commentaire.css">
    <title>Commentaire</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("submitBtn").addEventListener("click", function(event) {
                alert("Votre commentaire est envoyé.");
            });
        });
    </script>
</head>
<body>
    <div class="comment-container">
        <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $pseudo = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : '';
        ?>

        <form action="" method="POST" class="comment-left">
            <div class="comment-left-title">
                <h2>Commentaire</h2>
                <br>
            </div>
            <input type="text" name="pseudo" class="comment pseudo" required value="<?php echo htmlspecialchars($pseudo); ?>" placeholder="Pseudo">
            <br>
            <input type="text" name="reference" placeholder="Titre" class="comment reference" required>
            <br>
            <textarea name="commentaire" placeholder="Commentaire" class="comment commentaire" required></textarea>
            <br>
            <button type="submit" name="envoie" class="envoie" id="submitBtn">Envoyer</button>
        </form>
    </div>

    <?php
            // Traitement du formulaire
            if (isset($_POST['envoie'])) {  // Vérifier si le commentaire a été envoyé
                if (!empty($_POST['pseudo']) && !empty($_POST['reference']) && !empty($_POST['commentaire']) ) {
                    // Sécurisation des entrées
                    $pseudo = htmlspecialchars($_POST['pseudo']);
                    $reference = htmlspecialchars($_POST['reference']);
                    $date = date('Y-m-d');
                    $commentaire = htmlspecialchars($_POST['commentaire']);

                    try {
                        // Préparation et exécution de la requête SQL
                        $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
                        $stmt = $bdd->prepare("INSERT INTO comments (pseudo, reference, date, commentaire) VALUES (?, ?, ?, ?)");
                        $stmt->execute(array($pseudo, $reference, $date, $commentaire));
                    } catch (PDOException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                } 
            }
        ?>

    <br>
	<br>
	<br>

    <footer>
        <?php
            // Inclure le fichier header.php
            include 'footer.php';
        ?>
    </footer>
</body>
</html>