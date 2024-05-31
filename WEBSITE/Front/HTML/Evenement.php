
<?php
// Paramètres de connexion
$host = 'db';  // Utilisez le nom du service MySQL dans Docker Compose
$dbname = 'espace_membres';
$user = 'root';
$password = '';

// DSN de connexion
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    // Connexion à la base de données
    $bdd = new PDO($dsn, $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // En cas d'erreur de connexion
    echo 'Connection failed: ' . $e->getMessage();
    die(); // Arrête le script en cas d'erreur
}

// Démarrage de la session
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../CSS/Evenement.css">
        <script src="Evenement.js" defer></script>
        
        <title>Evenement</title> 
    </head>
    
 
        <?php
        // Inclure le fichier header.php
        include 'header.php';
        ?>

<body class="evenement-body">    
            <div class="content-promo">
                <div class="text">
                    <h1>Offre spéciale</h1>
                    <p>Profitez d'une réduction de 20% sur les billets du <strong>Festival de Nimes</strong></p>
                    <button>DECOUVRIR</button>
                </div>
                
                <div id="slider20">
                    <div class="slide-container">
                        <div class="custom-slider fade">
                            <div class="slide-index">1 / 3</div>
                            <img class="slide-img" src="https://infoccitanie.fr/wp-content/uploads/2022/06/B2A2463B-763C-498B-A714-A4599D1EB095.jpeg">
                            <div class="slide-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                        </div>
                        <div class="custom-slider fade">
                            <div class="slide-index">2 / 3</div>
                            <img class="slide-img" src="https://static.seetheworld.com/image_uploader/photos/91/original/festival-de-nimes-2020-nimes.jpg">
                            <div class="slide-text">Nullam luctus aliquam ornare.</div>
                        </div>
                        <div class="custom-slider fade">
                            <div class="slide-index">3 / 3</div>
                            <img class="slide-img" src="https://www.touslesfestivals.com/caches/917596f63c654b95aa32173381c337e2e21abe4f-1040x540-outbound.jpg">
                            <div class="slide-text">Praesent lobortis libero sed egestas suscipit.</div>
                        </div>
                        <a class="prev" onclick="plusSlide(-1, 'slider20')">&#10094;</a>
                        <a class="next" onclick="plusSlide(1, 'slider20')">&#10095;</a>
                    </div>
                    <br>
                    <div class="slide-dot">
                        <span class="dot" onclick="currentSlide(1, 'slider20')"></span>
                        <span class="dot" onclick="currentSlide(2, 'slider20')"></span>
                        <span class="dot" onclick="currentSlide(3, 'slider20')"></span>
                    </div>
                </div>
            </div>
            
            <main class="mainC">   
                <div class="event-header">
                    <div class="left">
                        <i class="fa-regular fa-user filters"></i>
                        <i class="fa-regular fa-bookmark filters"></i>
                        <?php
                        $allEvent = $bdd->query('SELECT * FROM evenements ORDER BY id DESC');
                        $searching = false;
                        if(isset($_GET['s']) AND !empty($_GET['s'])){
                            $recherche = htmlspecialchars($_GET['s']);
                            $allEvent = $bdd->query('SELECT * FROM evenements WHERE nom LIKE "%'.$recherche.'%" ORDER BY id DESC');
                            $searching = true;
                        }
                        ?>
                        <form method="GET">
                            <div class="search-bar">
                                <input type="text" name="s" placeholder="Rechercher..." autocomplete="off">

                                <button type="submit" name="envoyer">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
 
                        <i class="fa-solid fa-sliders filters"></i>
                    </div>
                    <div class="right">
                        <i class="fa-solid fa-cart-shopping filters"></i>
                    </div>
                    <!-- <i class="fa-regular fa-bag-shopping"></i> -->
                </div>
            
                <section class="afficherEvent">
                            <?php
                                if($searching){
                                    if($allEvent->rowCount() > 0){
                                        while($event = $allEvent->fetch()){
                                            ?>
                                            <div class="searchResult">
                                                <li class="card" data-target="detail<?= $event['id'] ?>">
                                                    <div class="img"><img src="<?= $event['image'] ?>" alt="img" draggable="false"></div>
                                                    <h2><?= $event['nom'] ?></h2>
                                                    <span><?= $event['localisation'] ?></span>
                                                    <span><?= date('j-n Y', strtotime($event['date_début'])) ?> - <?= date('j-n Y', strtotime($event['date_fin'])) ?></span>
                                                    <span class="price"><strong><?= $event['prix'] ?> &#8364;</strong> par jour</span>
                                                </li>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                    ?>
                                    <p>Aucun évènement trouvé</p>
                                    <?php
                                    }

                                }
                            ?>
                        </section>

                <!-- <div class="content-fest">
                    <h3>Festivals populaires</h3>
                    <i id="left-carousel1" class="fa-solid fa-angle-left arrow"></i>
                    <ul class="carousel-container carousel1">

                        <li class="card" data-target="détail1">
                            <div class="img"><img src="https://www.guettapen.com/wp-content/uploads/2019/06/Solidays-2019-2.jpg" alt="img" draggable="false"></div>
                            <h2>Solidays</h2>
                            <span>Paris-Longchamp</span>
                            <span>28-30 juin 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card" data-target="détail2">
                            <div class="img"><img src="https://www.francetvinfo.fr/pictures/PM2zCQ6oCISr8wmr_MKxNh3xkvk/1200x1200/2023/08/24/64e74e485f6d1_billie-eilish-9-olivierhoffschir.jpg" alt="img" draggable="false"></div>
                            <h2>Rock en Seine</h2>
                            <span>Saint-Cloud</span>
                            <span>21-25 août 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://weloveart.net/wp-content/uploads/2013/09/photo_wlg.jpeg" alt="img" draggable="false"></div>
                            <h2>We Love Green</h2>
                            <span>Paris</span>
                            <span>31 mai-2 juin 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://static.wixstatic.com/media/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg/v1/fill/w_640,h_426,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg" alt="img" draggable="false"></div>
                            <h2>Hellfest</h2>
                            <span>Clisson</span>
                            <span>27-30 juin 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.sncf-connect.com/assets/media/2022-05/eurockeennes.jpg" alt="img" draggable="false"></div>
                            <h2>Les Eurockéennes</h2>
                            <span>Belfort</span>
                            <span>4-7 juillet 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.parc-marais-poitevin.fr/wp-content/uploads/parc-naturel-regional-marais-poitevin-villes-de-nuit-vibrer-Franck_Moreau-1280-1280x610.jpg" alt="img" draggable="false"></div>
                            <h2>Les Francofolies</h2>
                            <span>La Rochelle</span>
                            <span>10-14 juillet 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://offloadmedia.feverup.com/marseillesecrete.com/wp-content/uploads/2022/04/13123511/Delta-Festival-Marseille-1024x576.jpg" alt="img" draggable="false"></div>
                            <h2>Le Delta Festival</h2>
                            <span>Marseille</span>
                            <span>4-8 septembre 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.longueurdondes.com/wp-content/uploads/2016/04/PDB2016_Ambiance_W@Marylene_Eytier-2968.jpg" alt="img" draggable="false"></div>
                            <h2>Le Printemps de Bourges</h2>
                            <span>Bourges</span>
                            <span>22-28 avril 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://static.actu.fr/uploads/2023/06/boby-boby-l1470093.jpg" alt="img" draggable="false"></div>
                            <h2>Rose Festival</h2>
                            <span>Aussonne</span>
                            <span>29 août-1 septembre 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://crtb.cloudly.space/app/uploads/crt-bretagne/2022/12/thumbs/Festival-Art-Rock_Gwendal-Le-Flem-1920x960.jpg" alt="img" draggable="false"></div>
                            <h2>Festival Art Rock</h2>
                            <span>Saint-Brieuc</span>
                            <span>17-19 mai 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                    </ul>
                    <i id="right-carousel1" class="fa-solid fa-angle-right arrow"></i> -->

            <?php  
            $fest = $bdd->query("SELECT * FROM evenements WHERE popular = true;");
            $festivals = $fest->fetchAll(PDO::FETCH_ASSOC);
             ?>

                <div class="content-fest">
                    <h3>Festivals populaires</h3>
                    <i id="left-carousel1" class="fa-solid fa-angle-left arrow"></i>
                    <ul class="carousel-container carousel1">
                        <?php foreach ($festivals as $festival): ?>
                        <li class="card" data-target="detail<?= $festival['id'] ?>">
                            <div class="img"><img src="<?= $festival['image'] ?>" alt="img" draggable="false"></div>
                            <h2><?= $festival['nom'] ?></h2>
                            <span><?= $festival['localisation'] ?></span>
                            <span><?= date('j-n Y', strtotime($festival['date_début'])) ?> - <?= date('j-n Y', strtotime($festival['date_fin'])) ?></span>
                            <span class="price"><strong><?= $festival['prix'] ?> &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <i id="right-carousel1" class="fa-solid fa-angle-right arrow"></i>
                  
                    
                    <?php foreach ($festivals as $festival): ?>
                    <div class="details" id="detail<?= $festival['id'] ?>">

                        <div class="leftSide">
                            <h2><?= htmlspecialchars($festival['nom']) ?></h2>
                            <div class="lieuDate">
                                <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($festival['localisation']) ?></span>    
                                <span><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars(date('j - n Y', strtotime($festival['date_début']))) ?> - <?= htmlspecialchars(date('j - n Y', strtotime($festival['date_fin']))) ?></span>                          
                            </div>
                            <div class="resume">
                                <h4><i class="fa-regular fa-pen-to-square"></i> Description</h4>
                                <p><?= htmlspecialchars($festival['description']) ?></p>
                            </div>
                            <div class="artists">
                                <h4><i class="fa-solid fa-music"></i> Artistes</h4>
                                <p><?= htmlspecialchars($festival['artistes']) ?></p>
                            </div>
                        </div>
                        
                        <div class="middleSide">
                            <h4><i class="fa-solid fa-ticket"></i> Billetterie</h4>
                            <span><?= htmlspecialchars($festival['prix']) ?> &#8364;</span>
                            <button class="cartButton">Ajouter au panier</button>
                            <button class="favButton">Ajouter aux favoris <i class="fa-regular fa-heart"></i></button>
                        </div>

                        <div class="rightSide" id="slider<?= $festival['id'] ?>">
                            <div class="slide-container">
                                <div class="custom-slider fade">
                                    <div class="slide-index">1 / 3</div>
                                    <img class="slide-img2" src="<?= htmlspecialchars($festival['imageDetail1']) ?>">
                                    <div class="slide-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                                </div>
                                <div class="custom-slider fade">
                                    <div class="slide-index">2 / 3</div>
                                    <img class="slide-img2" src="<?= htmlspecialchars($festival['imageDetail2']) ?>">
                                    <div class="slide-text">Nullam luctus aliquam ornare.</div>
                                </div>
                                <div class="custom-slider fade">
                                    <div class="slide-index">3 / 3</div>
                                    <img class="slide-img2" src="<?= htmlspecialchars($festival['imageDetail3']) ?>">
                                    <div class="slide-text">Praesent lobortis libero sed egestas suscipit.</div>
                                </div>
                                <a class="prev" onclick="plusSlide(-1, 'slider<?= $festival['id'] ?>')">&#10094;</a>
                                <a class="next" onclick="plusSlide(1, 'slider<?= $festival['id'] ?>')">&#10095;</a>
                            </div>
                        
                            <br>
                            <div class="slide-dot">
                                <span class="dot" onclick="currentSlide(1, 'slider<?= $festival['id'] ?>')"></span>
                                <span class="dot" onclick="currentSlide(2, 'slider<?= $festival['id'] ?>')"></span>
                                <span class="dot" onclick="currentSlide(3, 'slider<?= $festival['id'] ?>')"></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>


                <?php  
            $fest = $bdd->query("SELECT * FROM evenements WHERE type = 1;");
            $festivals = $fest->fetchAll(PDO::FETCH_ASSOC);
             ?>

                <div class="content-fest">
                    <h3>Festivals de Hip-hop / Rap</h3>
                    <i id="left-carousel2" class="fa-solid fa-angle-left arrow"></i>
                    <ul class="carousel-container carousel2">
                        <?php foreach ($festivals as $festival): ?>
                        <li class="card" data-target="detail<?= $festival['id'] ?>">
                            <div class="img"><img src="<?= $festival['image'] ?>" alt="img" draggable="false"></div>
                            <h2><?= $festival['nom'] ?></h2>
                            <span><?= $festival['localisation'] ?></span>
                            <span><?= date('j-n Y', strtotime($festival['date_début'])) ?> - <?= date('j-n Y', strtotime($festival['date_fin'])) ?></span>
                            <span class="price"><strong><?= $festival['prix'] ?> &#8364;</strong> par jour</span>
                            <i class="fa-solid fa-chevron-down" id="chevron"></i>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <i id="right-carousel2" class="fa-solid fa-angle-right arrow"></i>

                    <?php foreach ($festivals as $festival): ?>
                    <div class="details" id="detail<?= $festival['id'] ?>">

                        <div class="leftSide">
                            <h2><?= htmlspecialchars($festival['nom']) ?></h2>
                            <div class="lieuDate">
                                <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($festival['localisation']) ?></span>    
                                <span><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars(date('j - n Y', strtotime($festival['date_début']))) ?> - <?= htmlspecialchars(date('j - n Y', strtotime($festival['date_fin']))) ?></span>                          
                            </div>
                            <div class="resume">
                                <h4><i class="fa-regular fa-pen-to-square"></i> Description</h4>
                                <p><?= htmlspecialchars($festival['description']) ?></p>
                            </div>
                            <div class="artists">
                                <h4><i class="fa-solid fa-music"></i> Artistes</h4>
                                <p><?= htmlspecialchars($festival['artistes']) ?></p>
                            </div>
                        </div>
                        
                        <div class="middleSide">
                            <h4><i class="fa-solid fa-ticket"></i> Billetterie</h4>
                            <span><?= htmlspecialchars($festival['prix']) ?> &#8364;</span>
                            <button class="cartButton">Ajouter au panier</button>
                            <button class="favButton">Ajouter aux favoris <i class="fa-regular fa-heart"></i></button>
                        </div>

                        <div class="rightSide" id="slider<?= $festival['id'] ?>">
                            <div class="slide-container">
                                <div class="custom-slider fade">
                                    <div class="slide-index">1 / 3</div>
                                    <img class="slide-img2" src="<?= htmlspecialchars($festival['imageDetail1']) ?>">
                                    <div class="slide-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                                </div>
                                <div class="custom-slider fade">
                                    <div class="slide-index">2 / 3</div>
                                    <img class="slide-img2" src="<?= htmlspecialchars($festival['imageDetail2']) ?>">
                                    <div class="slide-text">Nullam luctus aliquam ornare.</div>
                                </div>
                                <div class="custom-slider fade">
                                    <div class="slide-index">3 / 3</div>
                                    <img class="slide-img2" src="<?= htmlspecialchars($festival['imageDetail3']) ?>">
                                    <div class="slide-text">Praesent lobortis libero sed egestas suscipit.</div>
                                </div>
                                <a class="prev" onclick="plusSlide(-1, 'slider<?= $festival['id'] ?>')">&#10094;</a>
                                <a class="next" onclick="plusSlide(1, 'slider<?= $festival['id'] ?>')">&#10095;</a>
                            </div>
                        
                            <br>
                            <div class="slide-dot">
                                <span class="dot" onclick="currentSlide(1, 'slider<?= $festival['id'] ?>')"></span>
                                <span class="dot" onclick="currentSlide(2, 'slider<?= $festival['id'] ?>')"></span>
                                <span class="dot" onclick="currentSlide(3, 'slider<?= $festival['id'] ?>')"></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>                    

                </div>

                <div class="content-fest">
                    <h3>Festivals de Rock</h3>
                    <i id="left-carousel3" class="fa-solid fa-angle-left arrow"></i>
                    <ul class="carousel-container carousel3">
                        <li class="card">
                            <div class="img"><img src="https://www.guettapen.com/wp-content/uploads/2019/06/Solidays-2019-2.jpg" alt="img" draggable="false"></div>
                            <h2>Solidays</h2>
                            <span>Paris-Longchamp</span>
                            <span>28-30 juin 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.francetvinfo.fr/pictures/PM2zCQ6oCISr8wmr_MKxNh3xkvk/1200x1200/2023/08/24/64e74e485f6d1_billie-eilish-9-olivierhoffschir.jpg" alt="img" draggable="false"></div>
                            <h2>Rock en Seine</h2>
                            <span>Saint-Cloud</span>
                            <span>21-25 août 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://weloveart.net/wp-content/uploads/2013/09/photo_wlg.jpeg" alt="img" draggable="false"></div>
                            <h2>We Love Green</h2>
                            <span>Paris</span>
                            <span>31 mai-2 juin 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://static.wixstatic.com/media/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg/v1/fill/w_640,h_426,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg" alt="img" draggable="false"></div>
                            <h2>Hellfest</h2>
                            <span>Clisson</span>
                            <span>27-30 juin 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.sncf-connect.com/assets/media/2022-05/eurockeennes.jpg" alt="img" draggable="false"></div>
                            <h2>Les Eurockéennes</h2>
                            <span>Belfort</span>
                            <span>4-7 juillet 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.parc-marais-poitevin.fr/wp-content/uploads/parc-naturel-regional-marais-poitevin-villes-de-nuit-vibrer-Franck_Moreau-1280-1280x610.jpg" alt="img" draggable="false"></div>
                            <h2>Les Francofolies</h2>
                            <span>La Rochelle</span>
                            <span>10-14 juillet 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://offloadmedia.feverup.com/marseillesecrete.com/wp-content/uploads/2022/04/13123511/Delta-Festival-Marseille-1024x576.jpg" alt="img" draggable="false"></div>
                            <h2>Le Delta Festival</h2>
                            <span>Marseille</span>
                            <span>4-8 septembre 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.longueurdondes.com/wp-content/uploads/2016/04/PDB2016_Ambiance_W@Marylene_Eytier-2968.jpg" alt="img" draggable="false"></div>
                            <h2>Le Printemps de Bourges</h2>
                            <span>Bourges</span>
                            <span>22-28 avril 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://static.actu.fr/uploads/2023/06/boby-boby-l1470093.jpg" alt="img" draggable="false"></div>
                            <h2>Rose Festival</h2>
                            <span>Aussonne</span>
                            <span>29 août-1 septembre 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://crtb.cloudly.space/app/uploads/crt-bretagne/2022/12/thumbs/Festival-Art-Rock_Gwendal-Le-Flem-1920x960.jpg" alt="img" draggable="false"></div>
                            <h2>Festival Art Rock</h2>
                            <span>Saint-Brieuc</span>
                            <span>17-19 mai 2024</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>   
                    </ul>
                    <i id="right-carousel3" class="fa-solid fa-angle-right arrow"></i>
                </div>
            </main>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
    <footer>
    <?php include 'footer.php';?>
    </footer>
</html>


