<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../CSS/header.css">
    
    <meta charset="utf-8" />
    <title>Accueil</title>
</head>
<body>

<header>
    <div class="logos">
        <div class="logoEklypsse">
            <img src="../Images/logo.png">
        </div>
        <a href="Home.php" style="margin-left:5px;font-size:22px;color:rgb(249, 186, 68);">SonoFest</a> 
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0,0,300,250">
        <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M7.71875,6.28125l-1.4375,1.4375l17.28125,17.28125l-17.28125,17.28125l1.4375,1.4375l17.28125,-17.28125l17.28125,17.28125l1.4375,-1.4375l-17.28125,-17.28125l17.28125,-17.28125l-1.4375,-1.4375l-17.28125,17.28125z"></path></g></g>
        </svg>
        <img src="../Images/logo_eventIT_app.png">
    </div>

    <ul class="liens">
        <li><a href="Evenement.php">Evenement</a></li>
        <li><a href="FAQ.php">F.A.Q</a></li>
        <li><a href="Contact.php">Contact</a></li>
        <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION['pseudo'])) {
                echo '<li><a href="Carte.php">Carte</a></li>';
            }
            if(isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === 'root' ) {
                echo '<li><a href="admin.php">Admin</a></li>';
            }
            
        ?>


    </ul>

    <div class="menu-lang">
        <div class="selected-lang">
            Français
        </div>
        <ul>
            <li>
                <a href="#" class="en">Anglais</a>
            </li>
            <li>
                <a href="#" class="sp">Espagnol</a>
            </li>
        </ul>
    </div>
    
    <?php
    // Vérifier automatiquement le cookie lors du chargement de la page
    if(isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
        // Connecter automatiquement l'utilisateur en utilisant $user_id
        // Remplacez cette ligne par votre logique pour connecter l'utilisateur
    }
    ?>

<div class="action-btn-container">
    <?php if (isset($_SESSION['id'])): ?>
        <div class="dropdown">
            <a href="#" class="action_btn"><?php echo $_SESSION['pseudo']; ?></a>
            <div class="dropdown-content">
                <a href="espace_personnel.php">Espace Personnel</a>
                <a href="messagerie.php">Messagerie</a>
                <a href="deconnexion.php" id="logout">Se Déconnecter</a>
            </div>
        </div>
    <?php else: ?>
        <a href="connexion.php" class="action_btn">Se connecter / S'inscrire</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === 'root' && isset($_SESSION['mdp']) && $_SESSION['mdp'] === 'root'): ?>
        <a href="admin.php"><i class="fa-solid fa-user-gear"></i></a>
    <?php endif; ?>
</div>


</header>



<footer>

</footer>

<script>
$(document).ready(function(){
    $('#logout').click(function(e){
        e.preventDefault();
        window.location.href = 'deconnexion.php';
    });
});
</script>

</body>
</html>
