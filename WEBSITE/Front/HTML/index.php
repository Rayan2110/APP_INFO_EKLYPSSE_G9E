<?php 
session_start();
if(!$_SESSION['mdp']){
	header('Location: connexion.php');
}
echo $_SESSION['pseudo'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
</head>
<body>
	<button><a href="deconnexion.php">Se déconnecter</a></button>
</body>
</html>