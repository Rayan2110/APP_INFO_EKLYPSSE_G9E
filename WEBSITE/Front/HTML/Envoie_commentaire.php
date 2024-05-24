<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/pages.css">
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

    <?php
        // Inclure le fichier header.php
        include 'header.php';
    ?>

    <div class="contact-container">
        <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $pseudo = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : '';
        ?>

        <form action="" method="POST" class="contact-left">
            <div class="contact-left-title">
                <h2>Comments</h2>
                <hr>
            </div>
            <input type="hidden" name="access_key" value="f0389b80-465b-4565-ab58-897042271442">
            <input type="text" name="pseudo" class="contact-inputs pseudo" required value="<?php echo htmlspecialchars($pseudo); ?>">
            <input type="text" name="reference" placeholder="Your object" class="contact-inputs reference" required>
            <textarea name="commentaire" placeholder="Your comments" class="contact-inputs commentaire" required></textarea>
            <button type="submit" name="envoie" id="submitBtn">Submit</button>
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