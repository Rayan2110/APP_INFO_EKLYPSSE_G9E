<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'root', 'Yanis2425262@');
if(isset($_POST['envoi'])){
    if(!empty($_POST['nom']) and !empty($_POST['mdp']) and !empty($_POST['pseudo']) and !empty($_POST['email']) and !empty($_POST['date_naissance']) and !empty($_POST['cmdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp']; // Ne pas hasher le mot de passe ici, nous allons le comparer avec password_verify()
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $date_naissance = htmlspecialchars($_POST['date_naissance']);
        $cmdp = $_POST['cmdp'];

        // Vérification s'il y a un doublon pour l'email donné
        $verifEmail = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $verifEmail->execute(array($email));
        $verifDoublon = $verifEmail->rowCount();
 
        if($verifDoublon !== 0){
            echo '<script>alert("Un compte avec cet email existe déjà.");</script>';
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
                echo '<script>alert("Le pseudo ou le nom ne doit pas contenir de caractères spéciaux.");</script>';
            } else {

                // Vérification s'il y a un doublon pour le pseudo donné
                $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
                $recupUser->execute(array($pseudo));
                $verifPseudo = $recupUser ->rowCount() ;

                if($verifPseudo !== 0){
                    echo '<script>alert("Un compte avec cet pseudo existe déjà");</script>';
                } else {

                    // Vérification des conditions pour un mot de passe
                    if(ConditionMotdePasse($mdp,$caracteres_speciaux) === false) {
                        // Une des contition n'est pas respecter                        
                    }else {

                        // Vérifier si les 2 mot de passe sont les même
                        if($mdp != $cmdp){
                            echo '<script>alert("Vos deux mot de passe ne sont pas les mêmes");</script>';
                        }
                        else {

                            // Récupération de l'utilisateur
                            $userInfo = $recupUser->fetch();

                            // Insertion de l'utilisateur avec mot de passe hashé
                            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
                            $insertUser = $bdd->prepare('INSERT INTO users(pseudo, nom,date_naissance,email,mdp) VALUES(?, ?,?,?,?)');
                            $insertUser->execute(array($pseudo, $nom, $date_naissance, $email, $mdpHash));

                            // Vérification du mot de passe
                            if(password_verify($mdp, $mdpHash)){
                                $_SESSION['pseudo'] = $pseudo;
                                $_SESSION['id'] = $recupUser->fetch()['id'];
                                echo '<script>alert("Vous êtes connecté en tant que ' . $_SESSION['pseudo'] . '");</script>';
                                header('Location: Home.php');
                            } else {
                                echo '<script>alert("Mot de passe incorrect");</script>';
                            }
                        }
                    }
                }
            } 
        } 
    } else {
    }
}

// Fonction de vérification pour le mot de passe
function ConditionMotdePasse($mdp,$caracteres_speciaux){

    // Vérification de nombre caractère minimum pour un mot de passe
    if (strlen($mdp) < 8) {
        echo '<script>alert("Votre mot de passe contient moins de 8 caractères");</script>';
        return false;
    }

    // Vérification de la présence d'au moins un caractère majuscule
    if (!preg_match('/[A-Z]/', $mdp)) {
        echo '<script>alert("Votre mot de passe ne contient pas de majuscule");</script>';
        return false;
    }

    // Vérification de la présence d'au moins un caractère minuscule
    if (!preg_match('/[a-z]/', $mdp)) {
        echo '<script>alert("Votre mot de passe ne contient pas de minuscule");</script>';
        return false;
    }

    // Vérification de la présence d'au moins un chiffre
    if (!preg_match('/[0-9]/', $mdp)) {
        echo '<script>alert("Votre mot de passe ne contient pas de chiffre");</script>';
        return false;
    }

    // Vérification de la présence d'au moins un caractère spécial
    $contient_special = false;
    foreach($caracteres_speciaux as $caractere) {
        if(strpos($mdp, $caractere) !== false) {
            $contient_special = true;
            break;
        }
    }

    if($contient_special == false) {
        echo '<script>alert("Votre mot de passe ne contient pas de caractères spéciaux");</script>';
        return false;
    }

    return true;
}
?>

<script>
    function validateForm() {
        // Récupération des valeurs des champs
        var nom = document.forms["monFormulaire"]["nom"].value;
        var pseudo = document.forms["monFormulaire"]["pseudo"].value;
        var email = document.forms["monFormulaire"]["email"].value;
        var date_naissance = document.forms["monFormulaire"]["date_naissance"].value;
        var mdp = document.forms["monFormulaire"]["mdp"].value;
        var cmdp = document.forms["monFormulaire"]["cmdp"].value;
        var checkbox = document.forms["monFormulaire"]["cocheun"];


        // Vérification des autres champs
        if (nom == "") {
            alert("Veuillez entrer votre nom.");
            return false;
        }
        if (nom.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/)) {
            alert("Le prénom ne doit pas contenir de caractères spéciaux.");
            return false;
        }
        if (pseudo == "") {
            alert("Veuillez entrer votre prénom.");
            return false;
        }
        if (pseudo.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/)) {
            alert("Le prénom ne doit pas contenir de caractères spéciaux.");
            return false;
        }
        if (email == "") {
            alert("Veuillez entrer votre adresse email.");
            return false;
        }


        if (date_naissance == "") {
            alert("Veuillez entrer votre date de naissance.");
            return false;
        }
        if (mdp == "") {
            alert("Veuillez entrer votre mot de passe.");
            return false;
        }
        if (mdp.length < 8) {
            alert("Votre mot de passe doit contenir au moins 8 caractères.");
            return false;
        }

        if (!mdp.match(/[A-Z]/)) {
            alert("Votre mot de passe ne contient pas de majuscule");
            return false;
        }

        // Vérification de la présence d'au moins un caractère minuscule
        if (!mdp.match(/[a-z]/)) {
            alert("Votre mot de passe ne contient pas de minuscule");
            return false;
        }

        // Vérification de la présence d'au moins un chiffre
        if (!mdp.match(/[0-9]/)) {
            alert("Votre mot de passe ne contient pas de chiffre");
            return false;
        }

        if (!mdp.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/)) {
            alert("Votre mot de passe doit contenir au moins un caractère spécial.");
            return false;
        }

        if (cmdp == "") {
            alert("Veuillez confirmer votre mot de passe.");
            return false;
        }

        // Vérification du mot de passe et de sa confirmation
        if (mdp !== cmdp) {
            alert("Les mots de passe ne correspondent pas.");
            return false;
        }

        // Vérification de la case à cocher
        if (!checkbox.checked) {
            alert("Veuillez accepter les conditions générales d'utilisation.");
            return false;
        }

        // Si toutes les validations passent, le formulaire est valide
        return true;
    }
</script>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=j, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/inscription.css?id=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script type="text/javascript">
        function TexteCondition(){
            alert("Votre mot de passe doit au moins contenir : \n- 8 caractères\n- un majuscule\n- un minuscule\n- un chiffre\n- un caractère spécial")
        }
    </script>
</head>
<body>
    <form id="monFormulaire"  action="" method="POST" onsubmit="return validateForm();">
        <h4>Inscription</h4>
        <div class="row">
            <input type="text" name="nom" class="nom" autocomplete="off" placeholder="nom">
            <input type="text" name="pseudo" class="prenom" autocomplete="off" placeholder="Prenom"> 
        </div>
        <br/>
        <input type="email" name="email" autocomplete="off" placeholder="Adresse mail">
        <!--
        <div class="select-box">
            <div class="selected-option">
                <div>
                    <span class="iconify" data-icon="flag:gb-4x3"></span>
                </div>
                <input type="tel" name="tel" placeholder="Phone Number">
            </div>
            <div class="options">
                <input type="text" class="search-box" placeholder="Search Country Name">
                <ol>

                </ol>
            </div>
        </div>
            -->
        <script src="scriptphone.js"></script>
        </div>
        <br/>
        <label for="date_naissance" style="color: white;">Date de naissance</label>
        <input type="date" name="date_naissance" placeholder="Date de naissance">
        <br/>
        <button onclick="TexteCondition()" class="BoutonCondition" name="BontonCondition" style="margin-left:40px;width:100px;margin-bottom:5px" >Condition</button>
        <input type="password" name="mdp" autocomplete="off" placeholder="Mot de Passe">
        <br/>
        <input type="password" name="cmdp" autocomplete="off" placeholder="Confirmer Mot de Passe">
        <br/>
        <div class="row">
            <input type="checkbox" name="cocheun" id="cocheun" >  
            <label for="cocheun" style="color: white;font-size: 14px;text-align: left;" >Je confirme avoir lu et accepté les <a href="#" style="font-size: 14px;">conditions générales d'utilisation</a> et <a href="#" style="font-size: 14px">mentions légales</a></label>
        </div> 
        <input type="submit" name="envoi" >
        <div class="row">
        <button type="button" name="Retour" onclick="document.location='Evenement.php'" class="retour" style="width: 50%;margin-left: 40px ; height:27px">Retour</button>
            <button type="button" name="Connecter" class="BoutonConnecter" onclick="document.location='connexion.php'" style="width: 50%; height:27px;margin-left:5px;margin-right: 40px">Se connecter</button>
        </div>
    </form>
    </div>
</body>
</html>
