<?php
// Commencer la session avant toute sortie HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../CSS/main.css">
    <title>Accueil</title>
    <style>
        .static-events {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .card {
            flex: 1 1 22%;
            box-sizing: border-box;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card .img {
            margin-bottom: 15px;
        }
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
        }
        .card h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color : black;
        }
        .card h2:hover {
            color: orange;
        }
        .card span {
            display: block;
            margin-bottom: 5px;
            color: #777;
        }
        .card .price {
            font-weight: bold;
            color: #333;
        }
        .box-container-what-we-do {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .box-what-we-do {
            flex: 1 1 30%;
            box-sizing: border-box;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }
        .box-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .box {
            flex: 1 1 30%;
            box-sizing: border-box;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php
    // Inclure le fichier header.php
    include 'header.php';
    ?>

    <main>
        <!-- Affichage page accueil texte sur image principale -->
        <section id="hero">
            <h1>Une qualité sonore inégalable</h1>
            <p>Explorez un univers de sons, de couleurs <br /> et d'énergie débordante à travers nos festivals passionnants. </p>
        </section>

        <?php  
        $host = 'db'; 
        $bdd = new PDO('mysql:host=$host;dbname=espace_membres', 'root', '');
        $fest = $bdd->query("SELECT * FROM evenements WHERE popular = true LIMIT 4;");
        $festivals = $fest->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="content-fest">
            <h3>Festivals populaires</h3>
            <ul class="static-events">
                <?php foreach ($festivals as $festival): ?>
                <li class="card">
                    <a href="Evenement.php">
                        <div class="img"><img src="<?= $festival['image'] ?>" alt="img" draggable="false"></div>
                        <h2><?= $festival['nom'] ?></h2>
                        <span><?= $festival['localisation'] ?></span>
                        <span><?= date('j-n Y', strtotime($festival['date_début'])) ?> - <?= date('j-n Y', strtotime($festival['date_fin'])) ?></span>
                        <span class="price"><strong><?= $festival['prix'] ?> &#8364;</strong> par jour</span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Affichage de la section what-we-do --> 
        <div class="box-container-what-we-do">
            <div class="services-section">
                <h2>Nos services</h2>
            </div>
            
            <div class="box-what-we-do">
                <h2>01</h2>
                <h3>Service One</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima, amet delectus fugit numquam asperiores quasi in velit mollitia quisquam! Ea eligendi vel eos excepturi voluptate quia amet inventore? Ex, assumenda.</p>
            </div>

            <div class="box-what-we-do">
                <h2>02</h2>
                <h3>Service Two</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima, amet delectus fugit numquam asperiores quasi in velit mollitia quisquam! Ea eligendi vel eos excepturi voluptate quia amet inventore? Ex, assumenda.</p>
            </div>

            <div class="box-what-we-do">
                <h2>03</h2>
                <h3>Service Three</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima, amet delectus fugit numquam asperiores quasi in velit mollitia quisquam! Ea eligendi vel eos excepturi voluptate quia amet inventore? Ex, assumenda.</p>
            </div>
        </div> 

        <!-- Affichage section programmation-->
        <div class="box-container">
            <div class="vertical-text">Programmation</div>
            <div class="box">
                <a href="Evenement.php">
                    <h3><b>Vendredi <br> 28 <br> juin</b></h3>
                </a>
            </div>
            <div class="box">
                <a href="Evenement.php">
                    <h3><b>Jeudi  <br>21<br> août</b></h3>
                </a>
            </div>
            <div class="box">
                <a href="Evenement.php">
                    <h3><b>Samedi <br> 4<br> septembre</b></h3>
                </a>
            </div>
        </div>

        <div class="chiffre"><h1>Des nombres qui attestent de notre réussite</h1></div>

        <div style="background-color: white;">
            <?php
                echo '<br>';
                include 'Afficher_commentaire.php';
                echo '<br>';
            ?>
        </div>
        
    </main>
    <footer>
        <?php
        // Inclure le fichier footer.php
        include 'footer.php';
        ?>
    </footer>
</body>
</html>
