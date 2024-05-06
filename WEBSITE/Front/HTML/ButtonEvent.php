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
    <link rel="stylesheet" href="../CSS/Evenement.css"> 
</head>

<?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>

<body class="eventBody">

    <main class="eventMain"> 
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
                <input class="ajouterBtn" type="submit" name="envoi" value="Ajouter l'événement" >
                
            </form>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Supprimer un événement</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
        </div>
        <div class="ajoutContainer">
            <div class="sousTitre">
                <h2>Modifier un événement</h2>
                <h3><i class="fa-solid fa-chevron-down"></i></h3>
            </div>
        </div>
    </main>


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
