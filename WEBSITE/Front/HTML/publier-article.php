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

    $recupArticle = $bdd->query('SELECT * FROM faq');
    while ($article = $recupArticle->fetch()) {
        ?>
        <div class="faq active">
            <button class="accordion">
                <?= $article['question'] ?>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="pannel">
                <p><?= $article['reponse'] ?></p>
                <!-- Add a hidden input to store the article ID -->
                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                <!-- Change the button to an input type="submit" -->
                <a href="delete.php?id=<?= $article['id'] ?>">
                <button style="color:white; background-color : red; margin-bottom : 10px;" >Supprimer</button></a>
                
            </div>
        </div>
<?php
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Ajouter une section F.A.Q</h1>


<form method="POST" action="">
    <input type="text" name="question" placeholder="Question">
    <br/>
    <textarea name="reponse" placeholder="Réponse"></textarea>
    <br/>
    <input type="submit" name="envoi">
    <input type="submit" name="supprimer" value="Supprimer une section">
</form>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;

            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
</body>