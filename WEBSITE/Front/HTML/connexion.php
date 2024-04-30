<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', '');
if(isset($_POST['envoi'])){
    if(!empty($_POST['pseudo']) and !empty($_POST['mdp'])){
        $pseudo_par_defaut = "root";
        $mdp_par_defaut = "root";
       
        // Code à exécuter si les champs pseudo et mdp ne sont pas vides
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp_clair = htmlspecialchars($_POST['mdp']);

        if ($_POST['pseudo'] == $pseudo_par_defaut && $_POST['mdp'] == $mdp_par_defaut) {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            $_SESSION['mdp'] = $_POST['mdp'];
            header('Location: admin.php');
        } 

        // On hash le mot de passe pour le stocker dans la base de données
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); 
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));

        if($recupUser->rowCount() > 0){
            // Si l'utilisateur existe
            $userInfo = $recupUser->fetch();
            $mdp_hash = $userInfo['mdp']; // Mot de passe haché de la base de données

            if (password_verify($mdp_clair, $mdp_hash)) {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $userInfo['id']; // Supposons que 'id' est le champ ID de l'utilisateur dans la base de données
                header('Location: Home.php');
            } else {
                echo '<script>alert("Mauvais mot de passe");</script>';
            }
        }
        else{
            echo '<script>alert("Mauvais identifiants");</script>';
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
    <label for="Pseudo">Pseudo :</label>
    <input type="text" name="pseudo" autocomplete="off" placeholder="Pseudo" >
    <br/>
    <label for="password">Mot de passe :</label>
    <input type="password" name="mdp" autocomplete="off" placeholder="Mot de passe" >
    <br/><br/>
    <button type="button" name="Inscrire" class="BoutonInscrire" onclick="document.location='inscription.php'">S'inscrire</button>
    <input type="submit" name="envoi" value="Se Connecter">
</form> 
</body>
</html>
