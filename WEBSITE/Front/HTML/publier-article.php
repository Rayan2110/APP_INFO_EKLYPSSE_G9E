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
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<?php
// Inclure le fichier header.php
include 'header.php';
?>
    
<body class="adminBody">

    <main class="adminMain"> 
        <button class="retourBtn" ><a href="admin.php">Retour</a></button>
        <div class="gestionTitre">
            <a href="admin.php" class="Admin"><h1>Admin </h1></a> 
            <h2>/ Gestion des FAQ</h2>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Ajouter une nouvelle FAQ</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <form method="POST" action=""  class="hidden ajoutFAQ">
                <input type="text" name="question" placeholder="Question">
                <br/>
                <textarea name="reponse" placeholder="Réponse"></textarea>
                <br/>
                <input type="submit" name="envoi" class="ajoutFaqBtn">

            </form>
        </div>

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



    ?>
<div class="ajoutContainer">
    <div class="sousTitre">
        <h2>Supprimer une FAQ</h2>
        <h3><i class="fa-solid fa-chevron-down"></i></h3>
    </div>
    <div class="liste hidden">
    <?php
    $bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');
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
?>
        </div>
    </div>
</main>
<footer>
    <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
    </footer>

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