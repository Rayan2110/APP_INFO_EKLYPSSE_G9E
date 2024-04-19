<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
if(isset($_POST['envoi'])){
    if(!empty($_POST['nom']) and !empty($_POST['mdp']) and !empty($_POST['pseudo']) and !empty($_POST['email']) and !empty($_POST['date_naissance']){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp']; // Ne pas hasher le mot de passe ici, nous allons le comparer avec password_verify()
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $date_naissance = htmlspecialchars($_POST['date_naissance']);

        // Insertion de l'utilisateur avec mot de passe hashé
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        $insertUser = $bdd->prepare('INSERT INTO users(pseudo, nom,date_naissance,email,mdp) VALUES(?, ?,?,?,?)');
        $insertUser->execute(array($pseudo, $nom, $date_naissance, $email, $mdpHash));

        // Récupération de l'utilisateur
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));
        $userInfo = $recupUser->fetch();

        // Vérification du mot de passe
        if(password_verify($mdp, $userInfo['mdp'])){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $userInfo['id'];
            $_SESSION['id'] = $recupUser->fetch()['id'];

            echo "Vous êtes connecté en tant que " . $_SESSION['pseudo'];
        } else {
            echo "Mot de passe incorrect";
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
