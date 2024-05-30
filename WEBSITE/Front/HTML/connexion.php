<?php 
session_start();
$bdd = new PDO('mysql:host=db;dbname=espace_membres', 'root', '');
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
<?php include 'header.php';?>
<body>
<br>
<br>
<form action="" method="POST">
    <h4>Connexion</h4>
    <br>
    <br>
    <br>
    <input type="text" name="email" autocomplete="off" placeholder="Email" style="border: 1px solid orange;">
    <br/>
    <input type="password" name="mdp" autocomplete="off" placeholder="Mot de passe" style="border: 1px solid orange;" >
    <br/>
    <input type="submit" name="envoi" value="Se Connecter">
    <div class="row">
        <button type="button" name = "Retour" class= "BoutonRetour" onclick="window.location.href='Home.php'" style="width: 50%;margin-left: 30px ; height:27px;border-radius: 10px 0px 0px 20px;"> Retour </button>
        <button type="button" name="Inscrire" class="BoutonInscrire" onclick="document.location='inscription.php'" style="width: 50%; height:27px;margin-left:5px;margin-right: 30px;border-radius: 0px 10px 20px 0px;background-color:orange;border:none">S'inscrire</button>
    </div>
</form> 
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php';?>
</body>
</html>
