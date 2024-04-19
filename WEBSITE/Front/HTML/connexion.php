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


        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // On hash le mot de passe pour le stocker dans la base de données
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));

        if($recupUser->rowCount() > 0){
            // Si l'utilisateur existe
            $userInfo = $recupUser->fetch();
            if ($userInfo !== false) {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['mdp'] = $mdp;
                header('Location: Home.php');
            } else {
                echo "Mauvais identifiants";
            }
        }
        else{
            echo "Mauvais identifiants";
        }
    }
    else{
        echo "Veuillez remplir tous les champs";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
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
