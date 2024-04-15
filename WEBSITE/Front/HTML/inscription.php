<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '#');
if(isset($_POST['envoi'])){
    if(!empty($_POST['pseudo']) and !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp']; // Ne pas hasher le mot de passe ici, nous allons le comparer avec password_verify()

        // Insertion de l'utilisateur avec mot de passe hashé
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        $insertUser = $bdd->prepare('INSERT INTO users(pseudo, mdp) VALUES(?, ?)');
        $insertUser->execute(array($pseudo, $mdpHash));

        // Récupération de l'utilisateur
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));
        $userInfo = $recupUser->fetch();

        // Vérification du mot de passe
        if(password_verify($mdp, $userInfo['mdp'])){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $userInfo['id'];

            echo $_SESSION['id'];
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
        <input type="text" name="pseudo" autocomplete="off">
        <br/>
        <input type="password" name="mdp" autocomplete="off">
        <br/><br/>
        <input type="submit" name="envoi">
    </form>
</body>
</html>
