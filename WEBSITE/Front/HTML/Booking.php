<?php
session_start();

if(!$_SESSION['id']){
    header('Location: connexion.php');
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialiser le mois sélectionné par défaut à juillet
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : '07';


$sql2 = "SELECT date_début, id, nom FROM evenements WHERE DATE_FORMAT(date_début, '%m') = '$selected_month'";




// Exécution de la requête SQL pour récupérer les dates et noms du mois sélectionné
$result2 = $conn->query($sql2);

// Tableaux pour stocker les dates et les noms des événements du mois sélectionné
$dates_mois = array();
$id_events = array();
$nom_events = array(); // Nouveau tableau pour stocker les noms des événements

// Vérifier si des résultats sont retournés
if ($result2->num_rows > 0) {
    // Parcourir chaque ligne de résultats
    while ($row = $result2->fetch_assoc()) {
        // Extraire le jour de la date récupérée
        $day = date("d", strtotime($row["date_début"]));
        // Ajouter le jour au tableau des dates du mois
        $dates_mois[] = $day;
        // Ajouter l'ID et le nom de l'événement aux tableaux correspondants
        $id_events[] = $row['id'];
        $nom_events[] = $row['nom']; // Ajouter le nom de l'événement
    }
} else {
    echo "Aucun résultat trouvé pour le mois sélectionné.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ticket Booking</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .tickets {
            width: 80%;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .dates-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .date-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            cursor: pointer;
        }

        .date-option:hover {
            background-color: #f9f9f9;
        }

        .selected {
            background-color: #4CAF50;
            color: #fff;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background-color: orange;
            color: #fff;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .month-select {
            margin-bottom: 20px;
        }
    </style>
    <?php include 'header.php';?>
</head>
<body>
<div class="container">
    <div class="tickets">
        <h1 class="title">Choose a Date for Ticket Booking</h1>
        <form id="date-form" method="post" action="">
            <select name="selected_month" class="month-select" onchange="this.form.submit();">
                <option value="01" <?php if ($selected_month == '01') echo 'selected'; ?>>January</option>
                <option value="02" <?php if ($selected_month == '02') echo 'selected'; ?>>February</option>
                <option value="03" <?php if ($selected_month == '03') echo 'selected'; ?>>March</option>
                <option value="04" <?php if ($selected_month == '04') echo 'selected'; ?>>April</option>
                <option value="05" <?php if ($selected_month == '05') echo 'selected'; ?>>May</option>
                <option value="06" <?php if ($selected_month == '06') echo 'selected'; ?>>June</option>
                <option value="07" <?php if ($selected_month == '07') echo 'selected'; ?>>July</option>
                <option value="08" <?php if ($selected_month == '08') echo 'selected'; ?>>August</option>
                <option value="09" <?php if ($selected_month == '09') echo 'selected'; ?>>September</option>
                <option value="10" <?php if ($selected_month == '10') echo 'selected'; ?>>October</option>
                <option value="11" <?php if ($selected_month == '11') echo 'selected'; ?>>November</option>
                <option value="12" <?php if ($selected_month == '12') echo 'selected'; ?>>December</option>
            </select>
        </form>
        <form id="book-form" method="post" action="traitement_reservation.php">
            <div class="dates-container">
                <?php
                foreach ($dates_mois as $index => $day) {
                    echo "<div class='date-option' data-date='$day'>$day<br/><span>{$nom_events[$index]}</span></div>";
                }
                ?>
            </div>
            <input type="hidden" name="selected_month" value="<?php echo htmlspecialchars($selected_month); ?>">
            <input type="hidden" name="selected_date" id="selected_date" />
            <button id="book-btn" class="btn" disabled>Book Tickets</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const datesContainer = document.querySelector(".dates-container");
        const bookBtn = document.getElementById("book-btn");
        const dateOptions = datesContainer.querySelectorAll(".date-option");
        const selectedDateInput = document.getElementById("selected_date");

        dateOptions.forEach(option => {
            option.addEventListener("click", function () {
                dateOptions.forEach(opt => opt.classList.remove("selected"));
                this.classList.add("selected");
                selectedDateInput.value = this.getAttribute("data-date");
                bookBtn.disabled = false;
            });
        });

        bookBtn.addEventListener("click", function (event) {
            if (!selectedDateInput.value) {
                event.preventDefault();
                alert("Please select a date before booking tickets.");
            }
        });
    });
</script>
<?php include 'footer.php';?>
</body>
</html>
