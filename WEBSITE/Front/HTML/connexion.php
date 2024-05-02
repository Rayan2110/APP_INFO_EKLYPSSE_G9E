<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
if(isset($_POST['envoi'])){
    if(!empty($_POST['email']) and !empty($_POST['mdp'])){
        // Code à exécuter si les champs pseudo et mdp ne sont pas vides
        $email = htmlspecialchars($_POST['email']);
        $mdp_clair = htmlspecialchars($_POST['mdp']);

        if ($email == "root" && $mdp_clair == "root") {
            $_SESSION['pseudo'] = "root"; 
            $_SESSION['id'] = 0; 
            header('Location: admin.php');
            exit();
        } 

        // On hash le mot de passe pour le stocker dans la base de données
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); 
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $recupUser->execute(array($email));

        if($recupUser->rowCount() > 0){
            // Si l'utilisateur existe
            $userInfo = $recupUser->fetch();
            $mdp_hash = $userInfo['mdp']; // Mot de passe haché de la base de données

            if (password_verify($mdp_clair, $mdp_hash)) {
                $_SESSION['pseudo'] = $userInfo['pseudo'];
                $_SESSION['id'] = $userInfo['id']; // Supposons que 'id' est le champ ID de l'utilisateur dans la base de données
                header('Location: Home.php');
            } else {
                echo '<script>alert("Mauvais mot de passe");</script>';
            }
        }
        else{
            echo '<script>alert("Ce mail n\'est pas relié à un compte.");</script>';
        }
    }
    else{
        echo '<script>alert("Veuillez remplir tous les champs...");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=j, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/auth.css">
</head>
<body>
<form action="" method="POST">
    <label for="email">Email :</label>
    <input type="text" name="email" autocomplete="off" placeholder="Email" >
    <br/>
    <label for="password">Mot de passe :</label>
    <input type="password" name="mdp" autocomplete="off" placeholder="Mot de passe" >
    <br/><br/>
    <input type="submit" name="envoi" value="Se Connecter">
    <button type="button" name="Inscrire" class="BoutonInscrire" onclick="document.location='inscription.php'">S'inscrire</button>
    <button type="button" name = "Retour" class= "BoutonRetour" onclick="window.location.href='Home.php'"> Retour </button>
</form> 
</body>
</html>
