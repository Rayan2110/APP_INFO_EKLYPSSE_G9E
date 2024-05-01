<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<?php
// Inclure le fichier header.php
include 'header.php';
?>
    
<a href="admin.php" class="Admin" ><h1>Admin</h1></a>
<br>
<h2>Ajouter une section F.A.Q</h2>
<br>

<form method="POST" action="">
    <input type="text" name="question" placeholder="Question">
    <br/>
    <textarea name="reponse" placeholder="Réponse"></textarea>
    <br/>
    <input type="submit" name="envoi">
    <input type="submit" name="supprimer" value="Supprimer une section">
</form>

<?php
if (isset($_POST['envoi'])) {
    if (!empty($_POST['question']) and !empty($_POST['reponse'])) {
        $question = htmlspecialchars($_POST['question']);
        $reponse = htmlspecialchars($_POST['reponse']);

        $bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');
        $insertArticle = $bdd->prepare('INSERT INTO faq(question, reponse) VALUES(?, ?)');
        $insertArticle->execute(array($question, $reponse));
    } else {
        echo "Veuillez remplir tous les champs...";
    }
}

if (isset($_POST['supprimer'])) {
    // Execute code for deleting FAQ entries
    $bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');

    ?>
    <h2>Liste des F.A.Q</h2> 
    <div class="liste">

    <?php
    $recupArticle = $bdd->query('SELECT * FROM faq');
    while ($article = $recupArticle->fetch()) {
        ?>
        <div class="faq active">
            <div class= "questRep">
                <button class="accordion">
                    <?= $article['question'] ?>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="pannel">
                    <p><?= $article['reponse'] ?></p>
                    <!-- Add a hidden input to store the article ID -->
                    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                </div>
            </div>
            <!-- Change the button to an input type="submit" -->
            <a href="delete.php?id=<?= $article['id'] ?>">
            <button class="btnDelete"><i class='bx bx-trash'></i> Supprimer</button></a>
        </div>
    
<?php
    }
}
?>
</div>


<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            var chevron = this.querySelector('.fa-chevron-down');

            if (panel.style.display === "flex") {
                panel.style.display = "none";
                chevron.classList.toggle("active2");
            } else {
                panel.style.display = "flex";
                chevron.classList.toggle("active2");
            }
        });
    }
</script>
</body>