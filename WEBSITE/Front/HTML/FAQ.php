
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link rel="stylesheet" href="../CSS/main.css"> -->
        <meta charset=" utf-8" />
        <title>F.A.Q</title>
        <link rel="stylesheet" href="../CSS/pages.css" />

    </head>
    <body>
    <?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>
                <main class="faqMain">
                <?php
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
</main>
               

        <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            var chevron = this.querySelector('.fa-chevron-down');
            
            if (panel.style.display === "block") {
                panel.style.display = "none";
                chevron.classList.toggle("active2");
            } else {
                panel.style.display = "block";
                chevron.classList.toggle("active2");
            }
        });
    }
        </script>

            <br>
    <br>
    <br>
    <br>
    
    </body>
    <footer class="faqMain">
    <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
    </footer>
</html>