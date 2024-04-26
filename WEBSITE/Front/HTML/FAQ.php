
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="main.css">
        <meta charset=" utf-8" />
        <title>F.A.Q</title>
        <link rel="stylesheet" href="pages.css" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>
    <body>
    <?php
                // Inclure le fichier header.php
                include 'header.php';

                $bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');

                $recupArticle = $bdd->query('SELECT * FROM faq');
                while($article = $recupArticle->fetch()){
                    ?>
                    <div class="faq active">
                        <button class="accordion">
                            <?= $article['question'] ?>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="pannel">
                            <p><?= $article['reponse'] ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>

               

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
    <footer>
            <div class="social-icons">
                <a href="#"><img src="facebook.png" alt="Facebook"></a>
                <a href="#"><img src="twitter.png" alt="Twitter"></a>
                <a href="#"><img src="instagram.png" alt="Instagram"></a>
            </div>
            <div class="footer-text">
                Réalisé par Eklypsse Sound
            </div>
            <div class="copyright">
                Copyright © 2024
            </div>
    </footer>
</html>