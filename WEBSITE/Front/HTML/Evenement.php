
<?php $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', ''); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="Evenement.css">
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
                
                <div id="slider1">
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
                        <a class="prev" onclick="plusSlide(-1, 'slider1')">&#10094;</a>
                        <a class="next" onclick="plusSlide(1, 'slider1')">&#10095;</a>
                    </div>
                    <br>
                    <div class="slide-dot">
                        <span class="dot" onclick="currentSlide(1, 'slider1')"></span>
                        <span class="dot" onclick="currentSlide(2, 'slider1')"></span>
                        <span class="dot" onclick="currentSlide(3, 'slider1')"></span>
                    </div>
                </div>
            </div>
            
            <main class="mainC">   
                <div class="event-header">
                    <div class="left">
                        <i class="fa-regular fa-user filters"></i>
                        <i class="fa-regular fa-bookmark filters"></i>
                        <div class="search-bar">
                            <input type="text" placeholder="Rechercher...">
                            <a href="#">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <i class="fa-solid fa-sliders filters"></i>
                    </div>
                    <div class="right">
                        <i class="fa-solid fa-cart-shopping filters"></i>
                    </div>
                    <!-- <i class="fa-regular fa-bag-shopping"></i> -->
                </div>


                <div class="content-fest">
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
                    <i id="right-carousel1" class="fa-solid fa-angle-right arrow"></i>


                    <div class="détails" id="détail1">

                        <div class="leftSide">
                            <h2>Solidays</h2>
                            <div class="lieuDate">
                                <span><i class="fa-solid fa-location-dot"></i> Paris-Longchamp</span>    
                                <span><i class="fa-solid fa-calendar-days"></i> 28 - 30 juin 2024</span>                          
                            </div>
                            <div class="resume">
                                <h4><i class="fa-regular fa-pen-to-square"></i> Description</h4>
                                <p>Solidays est un festival de musique organisé par l’association Solidarité sida. Depuis 1999, il rassemble des artistes, conférenciers, militants et festivaliers. 
                                    Durant les « 3 jours de musique et de solidarité » promis par les organisateurs, les bénéfices récoltés permettent de financer des programmes de prévention et d’aide aux malades du SIDA dans 21 pays.
                                </p>
                            </div>
                            <div class="artists">
                                <h4><i class="fa-solid fa-music"></i> Artistes</h4>
                                <p>GAZO & TIAKOLA - MARTIN GARRIX - PLK - MIKA - ZOLA - SDM - POMME - LOUISE ATTAQUE - WERENOI - CHARLOTTE CARDIN - LA FEVE - DIPLO - URUMI - VIENS LA FETE - TIF - SANTA - JETLAG GANG - SAM SMITH - ZAMDANE - SO LA LUNE - LA DARUDE - TRINIX - LAURENT GARNIER - STYLETO - BABY VOLCANO</p>
                            </div>
                        </div>
                        <div class="middleSide">
                            <h4><i class="fa-solid fa-ticket"></i> Billetterie</h4>
                            <span>180 &#8364;</span>
                            <button class="cartButton">Ajouter au panier</button>
                            <button class="favButton">Ajouter aux favoris <i class="fa-regular fa-heart"></i></button>
                        </div>
                        <div class="rightSide" id="slider2">
                            <div class="slide-container" >
                                <div class="custom-slider fade">
                                    <div class="slide-index">1 / 3</div>
                                    <img class="slide-img2" src="https://www.solidays.org/wp-content/uploads/2022/01/riles_1140_500_px-1140x570.jpg">
                                    <div class="slide-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                                </div>
                                <div class="custom-slider fade">
                                    <div class="slide-index">2 / 3</div>
                                    <img class="slide-img2" src="https://www.guettapen.com/wp-content/uploads/2023/11/363420158_660100122812004_8265898842019057879_n.jpeg">
                                    <div class="slide-text">Nullam luctus aliquam ornare.</div>
                                </div>
                                <div class="custom-slider fade">
                                    <div class="slide-index">3 / 3</div>
                                    <img class="slide-img2" src="https://www.soonnight.com/images/editor/1/fichiers/images/hippodrome-de-longchamp-l-773597_103.jpg">
                                    <div class="slide-text">Praesent lobortis libero sed egestas suscipit.</div>
                                </div>
                                <a class="prev" onclick="plusSlide(-1, 'slider2')">&#10094;</a>
                                <a class="next" onclick="plusSlide(1, 'slider2')">&#10095;</a>
                            </div>
                            <br>
                            <div class="slide-dot">
                                <span class="dot" onclick="currentSlide(1, 'slider2')"></span>
                                <span class="dot" onclick="currentSlide(2, 'slider2')"></span>
                                <span class="dot" onclick="currentSlide(3, 'slider2')"></span>
                            </div>
                        </div>
                    </div>

                    <div class="détails" id="détail2">
                        <h2>Rock en Seine</h2>
                    </div>
                </div>

                <div class="content-fest">
                    <h3>Festivals de Rap - Hip-hop</h3>
                    <i id="left-carousel2" class="fa-solid fa-angle-left arrow"></i>
                    <ul class="carousel-container  carousel2">
                        <li class="card">
                            <div class="img"><img src="https://www.lalibre.be/resizer/sm6KnxernBa1o26E-RAez0VBQWI=/1200x800/filters:format(jpeg):focal(895x556.5:905x546.5)/cloudfront-eu-central-1.images.arcpublishing.com/ipmgroup/V2SHFWTCCBAWZABISSQV7TXGGY.jpg" alt="img" draggable="false"></div>
                            <h2>Les Ardentes</h2>
                            <span>Liège (BE)</span>
                            <span>11-14 juillet</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://statics-infoconcert.digitick.com/media/a_effacer/lollapalooza_foule_visunews1222.jpg" alt="img" draggable="false"></div>
                            <h2>Lollapalooza</h2>
                            <span>Paris-Longchamp</span>
                            <span>5-7 juillet</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.quotidien-libre.fr/wp-content/uploads/2023/12/jfjhgkhgkhjkh-350x250.png" alt="img" draggable="false"></div>
                            <h2>Golden Coast Festival</h2>
                            <span>Dijon</span>
                            <span>13-14 septembre</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.guettapen.com/wp-content/uploads/2019/06/Solidays-2019-2.jpg" alt="img" draggable="false"></div>
                            <h2>Solidays</h2>
                            <span>Paris-Longchamp</span>
                            <span>28-30 juin</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://chorus.hauts-de-seine.fr/wp-content/uploads/2023/04/4.jpg" alt="img" draggable="false"></div>
                            <h2>Festival Chorus</h2>
                            <span>Boulogne-Billancourt</span>
                            <span>20-24 mars</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_1500,h_1000/https://krumpp.fr/wp-content/uploads/2023/05/@MAXLMNR_BOOMIN-FEST_-RENNES_10.jpg" alt="img" draggable="false"></div>
                            <h2>Boomin Fest</h2>
                            <span>Rennes</span>
                            <span>19-20 avril</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.touslesfestivals.com/uploads/acfd9d1c8d8474d6072d856214f118efeb2e425b/b6392eeabb61a5426766f317a278f9df6e1ae963.jpg" alt="img" draggable="false"></div>
                            <h2>Les Paradis Artificiels</h2>
                            <span>Lille</span>
                            <span>1-2 juin</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                        <li class="card">
                            <div class="img"><img src="https://www.jds.fr/medias/image/festival-marsatac-2-228912-1200-630.jpg" alt="img" draggable="false"></div>
                            <h2>Marsatac</h2>
                            <span>Marseille</span>
                            <span>14-16 juin</span>
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
                            <div class="img"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a1/Les_3_%C3%A9l%C3%A9phants_2022_-_Laylow_%28c%29Alexis_Janicot.jpg" alt="img" draggable="false"></div>
                            <h2>Les 3 éléphants</h2>
                            <span>Laval</span>
                            <span>26 mai-2 juin</span>
                            <span class="price"><strong>59 &#8364;</strong> par jour</span>
                        </li>
                    </ul>
                    <i id="right-carousel2" class="fa-solid fa-angle-right arrow"></i>
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
        
    </footer>
</html>

