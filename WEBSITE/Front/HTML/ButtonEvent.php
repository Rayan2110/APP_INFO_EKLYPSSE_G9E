<?php

// Traitement du formulaire
if (isset($_POST['envoi'])) {  // Vérifier si le formulaire a été envoyé
    if (!empty($_POST['nom']) && !empty($_POST['localisation']) && !empty($_POST['date_début']) && !empty($_POST['date_fin']) && !empty($_POST['prix']) && !empty($_POST['image']) && !empty($_POST['type'])) {
        // Sécurisation des entrées
        $nom = htmlspecialchars($_POST['nom']);
        $localisation = htmlspecialchars($_POST['localisation']);
        $date_debut = htmlspecialchars($_POST['date_début']);
        $date_fin = htmlspecialchars($_POST['date_fin']);
        $prix = htmlspecialchars($_POST['prix']);
        $image = htmlspecialchars($_POST['image']);
        $type = htmlspecialchars($_POST['type']);


        try {
            // Préparation et exécution de la requête SQL
            $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
            $stmt = $bdd->prepare("INSERT INTO evenements (nom, localisation, date_début, date_fin, prix, image, type) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($nom, $localisation, $date_debut, $date_fin, $prix, $image, $type));
            
            // Redirection après l'insertion
            header('Location: Evenement.php');
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Événement</title>
    <link rel="stylesheet" href="../CSS/admin.css"> 
    <!-- <link rel="stylesheet" href="../CSS/Evenement.css">  -->
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
            <h2>/ Gestion des évènements</h2>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Ajouter un nouvel événement</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <form method="POST" action="" class="hidden">
                <div class="champs">
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="nom">Nom de l'événement</label>
                            <input type="text" id="nom" name="nom" >
                        </div>
                        <div class="ajoutChamp">
                            <label for="localisation">Localisation</label>
                            <input type="text" id="localisation" name="localisation" >
                        </div>
                    </div>
                    <div class="champ1">
                        <div class="ajoutChamp">
                            <label for="date_début">Date de début</label>
                            <input type="date" id="date_début" name="date_début" >
                        </div>
                        <div class="ajoutChamp">
                            <label for="date_fin">Date de fin</label>
                            <input type="date" id="date_fin" name="date_fin" >
                        </div>
                    </div>
                    <div class="champ1">
                        <div class="ajoutChamp imag">
                            <label for="image">Image</label>
                            <input type="text" id="image" name="image" >
                        </div>
                        <div class="champ2">
                            <div class="ajoutChamp">
                                <label for="type">Type</label>
                                <input type="number" id="type" name="type" >
                            </div>
                            <div class="ajoutChamp">
                                <label for="prix">Prix par jour (€)</label>
                                <input type="number" id="prix" name="prix" >
                            </div>
                        </div>
                    </div>
                </div>
                <input class="ajouterBtn" type="submit" name="envoi" value="Ajouter" >
            </form>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Supprimer un événement</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
            <form method="POST" action="" class="hidden">
            <?php
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupération des événements depuis la base de données
                $requete = $bdd->query('SELECT id, nom, localisation, date_début, date_fin, prix FROM evenements');

                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<div class ="choixEvent">';
                echo '<label for="id_evenement">Sélectionnez un événement à supprimer</label>';
                echo '<select name="id_evenement" id="id_evenement">';
                
                while ($row = $requete->fetch()) {
                    echo '<option value="' . $row['id'] . '">' . $row['nom'] . ' - ' . $row['localisation'] . ' - ' . $row['date_début'] . ' - ' . $row['date_fin'] . ' - ' . $row['prix'] . '</option>';
                }

                echo '</select>';
                echo '</div>';

                echo '<input class="ajouterBtn" name="supprimer" type="submit" value="Supprimer">';
                echo '</form>';

                // Traitement de la suppression d'événement
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer'])) {
                    $id_evenement_a_supprimer = $_POST['id_evenement'];

                    // Suppression de l'événement sélectionné
                    $sql_suppression = "DELETE FROM evenements WHERE id = $id_evenement_a_supprimer";
                    $bdd->exec($sql_suppression);
                    echo "L'événement a été supprimé avec succès.";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        
            </form>
        </div>

        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Modifier un événement</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>

            <?php
                try {
                    $bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $requete = $bdd->query('SELECT id, nom, localisation, date_début, date_fin, prix, image, type FROM evenements');
                    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            ?>

            <form method="POST" action="" class="hidden">
                <div class="choixEvent">
                    <label for="id_evenement_mod">Sélectionnez un événement à modifier</label>
                    <select name="id_evenement_mod" id="id_evenement_mod">
                        <?php foreach ($events as $event) {
                            echo "<option value='{$event['id']}'>{$event['nom']} - {$event['localisation']}</option>";
                        } ?>
                    </select>
                </div>
                <button class= "ajouterBtn" type="button" onclick="loadEventData()">Choisir</button>
               

                <div id="eventDetails" style="display:none;">
                    <div class="champs">
                        <div class="champ1">
                            <div class="ajoutChamp">
                                <label for="nom">Nom de l'événement</label>
                                <input type="text" id="nomM" name="nom">
                            </div>
                            <div class="ajoutChamp">
                                <label for="localisation">Localisation</label>
                                <input type="text" id="localisationM" name="localisation">
                            </div>
                        </div>
                        <div class="champ1">
                            <div class="ajoutChamp">
                                <label for="date_début">Date de début</label>
                                <input type="date" id="date_debutM" name="date_début">
                            </div>
                            <div class="ajoutChamp">
                                <label for="date_fin">Date de fin</label>
                                <input type="date" id="date_finM" name="date_fin">
                            </div>
                        </div>
                        <div class="champ1">
                            <div class="ajoutChamp imag">
                                <label for="image">Image</label>
                                <input type="text" id="imageM" name="image">
                            </div>
                            <div class="champ2">
                                <div class="ajoutChamp">
                                    <label for="type">Type</label>
                                    <input type="number" id="typeM" name="type">
                                </div>
                                <div class="ajoutChamp">
                                    <label for="prix">Prix par jour (€)</label>
                                    <input type="text" id="prixM" name="prix">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="ajouterBtn" type="submit" name="modifier" value="Modifier">
                </div>
            </form>

            <script>
                function loadEventData() {
                    var selectedIndex = document.getElementById('id_evenement_mod').value;
                    var eventDetails = <?php echo json_encode($events); ?>;
                    
                    var selectedEvent = eventDetails.find(event => event.id == selectedIndex);
                    if (selectedEvent) {
                        document.getElementById('nomM').value = selectedEvent.nom;
                        document.getElementById('localisationM').value = selectedEvent.localisation;
                        document.getElementById('date_debutM').value = selectedEvent.date_début;
                        document.getElementById('date_finM').value = selectedEvent.date_fin;
                        document.getElementById('prixM').value = selectedEvent.prix;
                        document.getElementById('imageM').value = selectedEvent.image;
                        document.getElementById('typeM').value = selectedEvent.type;
                        document.getElementById('eventDetails').style.display = 'block';
                    }
                }
            </script>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
                    $id = $_POST['id_evenement_mod'];
                    $nom = htmlspecialchars($_POST['nom']);
                    $localisation = htmlspecialchars($_POST['localisation']);
                    $date_debut = htmlspecialchars($_POST['date_début']);
                    $date_fin = htmlspecialchars($_POST['date_fin']);
                    $prix = htmlspecialchars($_POST['prix']);
                    $image = htmlspecialchars($_POST['image']);
                    $type = htmlspecialchars($_POST['type']);

                    try {
                        $stmt = $bdd->prepare("UPDATE evenements SET nom = ?, localisation = ?, date_début = ?, date_fin = ?, prix = ?, image = ?, type = ? WHERE id = ?");
                        $stmt->execute([$nom, $localisation, $date_debut, $date_fin, $prix, $image, $type, $id]);
                        echo "<p>L'événement a été modifié avec succès.</p>";
                    } catch (PDOException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
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
    <script>

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
</html>
