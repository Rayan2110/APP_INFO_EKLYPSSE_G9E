        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="../CSS/main.css">
            <meta charset=" utf-8" />
            <title>Accueil</title>
        </head>
        <body>

                <?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>
                    


        <main>

            <!-- Affichage page accueil texte sur image principale-->
            
            <section id="hero">
                <h1>Une qualité sonore inégalable</h1>
                <p>Explorez un univers de sons, de couleurs <br /> et d'énergie débordante à travers nos festivals passionnants. </p>
            </section>


            <div class="content-fest">
                <h3>Les festivals à venir</h3>
                <i id="left-carousel1" class="fa-solid fa-angle-left arrow"></i>
                <ul class="carousel-container carousel1">
                    <li class="card">
                        <div class="img"><img src="https://www.guettapen.com/wp-content/uploads/2019/06/Solidays-2019-2.jpg" alt="img" draggable="false"></div>
                        <h2>Solidays</h2>
                        <span>Paris-Longchamp</span>
                        <span>28-30 juin 2024</span>
                        <dev class="chevron-zone">
                            <i class="fa-solid fa-chevron-down"></i>
                        </dev>
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://www.francetvinfo.fr/pictures/PM2zCQ6oCISr8wmr_MKxNh3xkvk/1200x1200/2023/08/24/64e74e485f6d1_billie-eilish-9-olivierhoffschir.jpg" alt="img" draggable="false"></div>
                        <h2>Rock en Seine</h2>
                        <span>Saint-Cloud</span>
                        <span>21-25 août 2024</span>
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://weloveart.net/wp-content/uploads/2013/09/photo_wlg.jpeg" alt="img" draggable="false"></div>
                        <h2>We Love Green</h2>
                        <span>Paris</span>
                        <span>31 mai-2 juin 2024</span>
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://static.wixstatic.com/media/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg/v1/fill/w_640,h_426,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg" alt="img" draggable="false"></div>
                        <h2>Hellfest</h2>
                        <span>Clisson</span>
                        <span>27-30 juin 2024</span>
                        
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://www.sncf-connect.com/assets/media/2022-05/eurockeennes.jpg" alt="img" draggable="false"></div>
                        <h2>Les Eurockéennes</h2>
                        <span>Belfort</span>
                        <span>4-7 juillet 2024</span>
                        
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://www.parc-marais-poitevin.fr/wp-content/uploads/parc-naturel-regional-marais-poitevin-villes-de-nuit-vibrer-Franck_Moreau-1280-1280x610.jpg" alt="img" draggable="false"></div>
                        <h2>Les Francofolies</h2>
                        <span>La Rochelle</span>
                        <span>10-14 juillet 2024</span>
                       
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://offloadmedia.feverup.com/marseillesecrete.com/wp-content/uploads/2022/04/13123511/Delta-Festival-Marseille-1024x576.jpg" alt="img" draggable="false"></div>
                        <h2>Le Delta Festival</h2>
                        <span>Marseille</span>
                        <span>4-8 septembre 2024</span>
                       
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://www.longueurdondes.com/wp-content/uploads/2016/04/PDB2016_Ambiance_W@Marylene_Eytier-2968.jpg" alt="img" draggable="false"></div>
                        <h2>Le Printemps de Bourges</h2>
                        <span>Bourges</span>
                        <span>22-28 avril 2024</span>
                        
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://static.actu.fr/uploads/2023/06/boby-boby-l1470093.jpg" alt="img" draggable="false"></div>
                        <h2>Rose Festival</h2>
                        <span>Aussonne</span>
                        <span>29 août-1 septembre 2024</span>
                        
                    </li>
                    <li class="card">
                        <div class="img"><img src="https://crtb.cloudly.space/app/uploads/crt-bretagne/2022/12/thumbs/Festival-Art-Rock_Gwendal-Le-Flem-1920x960.jpg" alt="img" draggable="false"></div>
                        <h2>Festival Art Rock</h2>
                        <span>Saint-Brieuc</span>
                        <span>17-19 mai 2024</span>
                       
                    </li>
                </ul>
                <i id="right-carousel1" class="fa-solid fa-angle-right arrow"></i>
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
                    <a href="Evenement.html">
                        <h3><b>Vendredi <br> 14 <br> juillet</b></h3>
                    </a>
                </div>

                <div class="box">
                    <a href="Evenement.html">
                    <h3> <b> Jeudi  <br>14 <br> juillet</b></h3>
                </a>
                </div>

                <div class="box">
                    <a href="Evenement.html">
                    <h3> <b>Samedi <br> 14 <br> juillet</b></h3>
                    </a>
                </div>

            </div>

            <div class ="chiffre"><h1> Des nombres qui attestent de notre réussite</h1></div>
            
            <div style="background-color: white;" >
                <?php
                    echo'<br>';
                    include 'Afficher_commentaire.php';
                    echo'<br>';
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                ?>
            </div>
        
        </main>
        <footer>
        <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
        </footer>
        </body>
        </html>
