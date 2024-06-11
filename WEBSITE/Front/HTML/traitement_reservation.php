<?php
session_start();

// Connexion à la base de données
$servername = "db";
$username = "root";
$password = "";
$dbname = "espace_membres";

// Création de la connexion
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Déclarer la variable qui va stocker l'ID de l'événement
$eventID = '';
$name = ''; // Initialiser la variable $name

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de l'utilisateur à partir de la session
    $idUser = $_SESSION['id']; // Supposons que vous ayez stocké l'ID de l'utilisateur dans la session

    // Récupérer le mois et la date sélectionnés depuis le formulaire
    $selected_month = $_POST['selected_month'];
    $selected_date = $_POST['selected_date'];

    // Préparer la requête SQL pour obtenir l'ID de l'événement
    $sql = "SELECT id, nom FROM evenements WHERE DATE_FORMAT(date_début, '%m') = :selected_month AND DATE_FORMAT(date_début, '%d') = :selected_date";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['selected_month' => $selected_month, 'selected_date' => $selected_date]);
    $resultatid = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si des résultats ont été trouvés
    if ($resultatid) {
        // Extraire le premier résultat (dans ce cas, l'ID de l'événement)
        $eventID = $resultatid['id'];
        $name = $resultatid['nom'];
    } else {
        $eventID = null;
    }

    // Vérifier si un ID d'événement valide a été trouvé
    if (is_numeric($eventID)) {
        // Insérer l'utilisateur et l'événement dans la table billet
        $insertUser = $conn->prepare('INSERT INTO billet (id_users, id_evenements) VALUES (:idUser, :eventID)');
        $insertUser->execute(['idUser' => $idUser, 'eventID' => $eventID]);
    } else {
        echo "Invalid event ID. Unable to insert into billet table.";
    }
}

// Fermer la connexion à la base de données
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/espace_personnel.css">
    <title>Achat réussi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
        }

        p {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Achat bien effectué</h1>
        <p>Merci pour votre achat ! A bientôt pour le festival : <?php echo htmlspecialchars($name); ?></p>
        <p>Vous pouvez consulter vos événements dans votre espace membre.</p>

        <button class="btn" onclick="window.location.href = 'index
        .php';">Retour à l'accueil</button>
    </div>
</body>
</html>
