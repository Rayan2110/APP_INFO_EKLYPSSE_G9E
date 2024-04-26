<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');
if(isset($_GET['id'])){
    $getid = $_GET['id'];
    $deletesection = $bdd->prepare('SELECT * FROM faq WHERE id = ?');
    $deletesection->execute(array($getid));
    if($deletesection->rowCount() > 0){
        $deletesection = $bdd->prepare('DELETE FROM faq WHERE id = ?');
        $deletesection->execute(array($getid));
        header('Location: FAQ.php');
    }
    else{
        echo "Cette section n'existe pas...";}

    header('Location: publier-article.php');
}
?>