<?php
// Connexion à la base de données (remplacez les valeurs par les vôtres)
$servername = "localhost";
$username = "nom_utilisateur";
$password = "mot_de_passe";
$dbname = "nom_base_de_donnees";

//$conn = new mysqli($servername, $username, $password, $users);



// Récupérer les informations de l'utilisateur depuis la base de données (suppose que vous avez une table 'utilisateurs')
// Vous devez d'abord récupérer les informations de l'utilisateur pour les afficher dans les champs de modification

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Mettre à jour les informations de l'utilisateur dans la base de données
    $sql = "UPDATE utilisateurs SET prenom='$prenom', nom='$nom', email='$email', mot_de_passe='$mot_de_passe' WHERE id_utilisateur='$id_utilisateur'";

    if ($conn->query($sql) === TRUE) {
        echo "Informations mises à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour des informations : " . $conn->error;
    }
}


?>

<!-- Formulaire HTML pour permettre à l'utilisateur de modifier ses informations -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Prenom: <input type="text" name="prenom"><br>
    Nom: <input type="text" name="nom"><br>
    Email: <input type="email" name="email"><br>
    Mot de passe: <input type="password" name="mot_de_passe"><br>
    <input type="submit" value="Modifier">
</form>
