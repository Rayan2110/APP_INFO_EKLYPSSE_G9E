<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
if(isset($_POST['envoi'])){
    if(!empty($_POST['nom']) and !empty($_POST['mdp']) and !empty($_POST['pseudo']) and !empty($_POST['email']) and !empty($_POST['date_naissance'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp']; // Ne pas hasher le mot de passe ici, nous allons le comparer avec password_verify()
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $date_naissance = htmlspecialchars($_POST['date_naissance']);

        // Vérification s'il y a un doublon pour l'email donné
        $verifEmail = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $verifEmail->execute(array($email));
        $verifDoublon = $verifEmail->rowCount();
 
        if($verifDoublon !== 0){
            echo "Erreur: Un compte avec cet email existe déjà.";
        } else {
            
            // Liste des caractères spéciaux à vérifier
            $caracteres_speciaux = array('/', '@', '$', '&', '*', '+', '-', '_', '=', '{', '}', '[', ']', '(', ')', '<', '>', '|', '\\', ':', ';', '"', '\'', '.', ',', '?', '!', '~', '`', '^', '°', '§');

            // Vérification si le pseudo contient des caractères spéciaux
            $contient_special = false;
            foreach($caracteres_speciaux as $caractere) {
                if(strpos($pseudo, $caractere) !== false || strpos($nom, $caractere) !== false) {
                    $contient_special = true;
                    break;
                }
            }

            if($contient_special == true) {
                echo "Le pseudo ou le nom ne doit pas contenir de caractères spéciaux.";
            } else {

                // Vérification s'il y a un doublon pour le pseudo donné
                $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
                $recupUser->execute(array($pseudo));
                $verifPseudo = $recupUser ->rowCount() ;

                if($verifPseudo !== 0){
                    echo "Erreur: Un compte avec cet pseudo existe déjà";
                } else {

                    // Récupération de l'utilisateur
                    $userInfo = $recupUser->fetch();

                    // Insertion de l'utilisateur avec mot de passe hashé
                    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
                    $insertUser = $bdd->prepare('INSERT INTO users(pseudo, nom,date_naissance,email,mdp) VALUES(?, ?,?,?,?)');
                    $insertUser->execute(array($pseudo, $nom, $date_naissance, $email, $mdpHash));
 
                    // Vérification du mot de passe
                    if(password_verify($mdp, $mdpHash)){
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['id'] = $userInfo['id'];
                        $_SESSION['id'] = $recupUser->fetch()['id'];
                        echo "Vous êtes connecté en tant que " . $_SESSION['pseudo'];
                    } else {
                        echo "Mot de passe incorrect";
                    }
                }
            } 
        } 
    } else {
        echo "Veuillez remplir tous les champs...";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=j, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" autocomplete="off">
        <br/>
        <label for="prenom">Prénom:</label>
        <input type="text" name="pseudo" autocomplete="off">
        <br/>
        <label for="email">Email:</label>
        <input type="email" name="email" autocomplete="off">
        <br/>
        <label for="date_naissance">Date de naissance:</label>
        <input type="date" name="date_naissance">
        <br/>
        <label for="mdp">Mot de passe:</label>
        <input type="password" name="mdp" autocomplete="off">
        <br/><br/>
        <input type="submit" name="envoi">
    </form>
</body>
</html>
