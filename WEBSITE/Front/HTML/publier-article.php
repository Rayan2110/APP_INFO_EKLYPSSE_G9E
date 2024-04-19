<?php
if(isset($_POST['envoi'])){
    if(!empty($_POST['question']) and !empty($_POST['reponse'])){
        $question = htmlspecialchars($_POST['question']);
        $reponse = htmlspecialchars($_POST['reponse']);

        $bdd = new PDO('mysql:host=localhost;dbname=espace_admins', 'root', '');
        $insertArticle = $bdd->prepare('INSERT INTO faq(question, reponse) VALUES(?, ?)');
        $insertArticle->execute(array($question, $reponse));
    } else {
        echo "Veuillez remplir tous les champs...";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ajouter une section F.A.Q</h1>
    

    <form method="POST" action"">
        <input type="text" name="question" placeholder="Question">
        <br/>
        <textarea name="reponse" placeholder="Réponse"></textarea>
        <br/>
        <input type="submit" name="envoi">

        </form>
</body>
</html>