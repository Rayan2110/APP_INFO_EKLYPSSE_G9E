<?php
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

// Requête SQL pour récupérer les initiales du festival "We Love Green"
$sql = "SELECT initiales FROM evenements WHERE nom = 'We Love Green'";
$sql2 = "SELECT date_début FROM evenements WHERE date_début LIKE '2024-06%'";

// Exécution de la requête SQL pour récupérer les initiales
$resultInitiales = $conn->query($sql);

// Variable pour stocker les initiales
$initiales = '';

// Vérifier si des résultats sont retournés
if ($resultInitiales->num_rows > 0) {
    // Récupérer les initiales
    while ($row = $resultInitiales->fetch_assoc()) {
        $initiales = $row['initiales'];
    }
} else {
    echo "Aucun résultat trouvé pour les initiales du festival.";
}

// Exécution de la requête SQL pour récupérer les dates de juin
$result2 = $conn->query($sql2);

// Tableau pour stocker les dates de juin
$dates_juin = array();

// Vérifier si des résultats sont retournés
if ($result2->num_rows > 0) {
    // Parcourir chaque ligne de résultats
    while ($row = $result2->fetch_assoc()) {
        // Extraire le jour de la date récupérée
        $day = date("d", strtotime($row["date_début"]));
        // Ajouter le jour au tableau des dates de juin
        $dates_juin[] = $day;
    }
} else {
    echo "Aucun résultat trouvé pour le mois de juin.";
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
    <!--Google Fonts and Icons-->
    <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone"
            rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet"/>
    <style>
        body {
            width: 100%;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .center {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, rgb(255, 179, 102), rgb(255, 102, 0));

        }

        .tickets {
            width: 550px;
            height: fit-content;
            border: 0.4mm solid rgba(0, 0, 0, 0.08);
            border-radius: 3mm;
            box-sizing: border-box;
            padding: 10px;
            font-family: poppins;
            max-height: 96vh;
            overflow: auto;
            background: white;
            box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .ticket-selector {
            background: rgb(243, 243, 243);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: column;
            box-sizing: border-box;
            padding: 20px;
        }

        .head {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 16px;
            font-weight: 600;
        }

        .seats {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 150px;
            position: relative;
        }

        .status {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }

        .seats::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translate(-50%, 0);
            width: 220px;
            height: 7px;
            background: rgb(141, 198, 255);
            border-radius: 0 0 3mm 3mm;
            border-top: 0.3mm solid rgb(180, 180, 180);
        }

        .day {
            font-size: 12px;
            position: relative;
        }

        .day::before {
            content: "";
            position: absolute;
            top: 50%;
            left: -12px;
            transform: translate(0, -50%);
            width: 10px;
            height: 10px;
            background: rgb(255, 255, 255);
            outline: 0.2mm solid rgb(120, 120, 120);
            border-radius: 0.3mm;
        }

        .day:nth-child(2)::before {
            background: rgb(180, 180, 180);
            outline: none;
        }

        .day:nth-child(3)::before {
            background: linear-gradient(to right, rgb(255, 179, 102), rgb(255, 102, 0));
            outline: none;
        }

        .all-seats {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 15px;
            margin: 60px 0;
            margin-top: 20px;
            position: relative;
        }

        .seat {
            width: 40px;
            height: 40px;
            margin-bottom: 40px;
            background: white;
            border-radius: 0.5mm;
            outline: 0.3mm solid rgb(180, 180, 180);
            cursor: pointer;
        }

        .all-seats input:checked + label {
            background: linear-gradient(to right, rgb(255, 179, 102), rgb(255, 102, 0));
            outline: none;
        }

        .seat.booked {
            background: black;
            outline: none;
        }

        input {
            display: none;
        }

        .timings {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
        }

        .dates {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dates-item {
            width: 100px; /* Augmentation de la largeur */
            height: 200px; /* Augmentation de la hauteur */
            background: rgb(233, 233, 233);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 10px 0;
            border-radius: 2mm;
            cursor: pointer;
        }

        .day {
            font-size: 12px;
        }

        .price {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .total {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            font-size: 16px;
            font-weight: 500;
        }

        .total span {
            font-size: 11px;
            font-weight: 400;
        }

        .price button {
            background: rgb(60, 60, 60);
            color: white;
            font-family: poppins;
            font-size: 14px;
            padding: 7px 14px;
            border-radius: 2mm;
            outline: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="center">
    <div class="tickets">
        <div class="ticket-selector">
            <div class="head">
                <div class="title">Festivals disponibles en Mai </div>
            </div>
            <div class="seats">
                <div class="status">
                    <div class="day">Available</div>
                    <div class="day">Booked</div>
                    <div class="day">Selected</div>
                </div>
                                <div class="all-seats">
                                <?php
                    for ($i = 1; $i <= 31; $i++) {
                        // Vérifier si le jour actuel est dans le tableau des jours récupérés
                        if (in_array($i, $dates_juin)) {
                            // Si oui, rendre la case disponible
                            $labelContent = "<div class='day-number'>$i</div>";
                            $bookedClass = "";
                            // Intégrer les initiales récupérées dans la requête SQL
                            $seatContent = "<div class='initiales'>$initiales</div>";
                        } else {
                            // Sinon, rendre la case indisponible
                            $labelContent = "";
                            $bookedClass = "booked";
                            $seatContent = "";
                        }

                        echo "<input type='checkbox' name='tickets' id='s$i' />";
                        echo "<label for='s$i' class='seat $bookedClass'>";
                        echo $labelContent;
                        echo $seatContent;
                        echo "</label>";
                    }
                    ?>
                </div>

                <div class="timings">
                    <div class="dates">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            if (in_array($i, $dates_juin)) {
                                echo "<input type='radio' name='date' id='d$i' />";
                                echo "<label for='d$i' class='dates-item'>";
                                echo "<div class='day'>Sun</div>"; // Modifier pour inclure le jour de la semaine si nécessaire
                                echo "<div class='date'>$i</div>";
                                echo "</label>";
                            }
                        }
                        ?>
    </div>
</div>



    <form id="reservation-form" method="post" action="traitement_reservation.php">
            <!-- Autres éléments de formulaire ici -->
            <div class="price">
                <div class="total">
                    <span> <span class="count">0</span> Tickets </span>
                    <div class="amount">0</div>
                </div>
                <button type="submit" name="Booking">Bookinnn</button> <!-- Ajouter un attribut name -->
            </div>
            </div>
        </form>
    
</div>

<script>
    let seats = document.querySelector(".all-seats");
    let tickets = seats.querySelectorAll("input");
    tickets.forEach((ticket) => {
        ticket.addEventListener("change", () => {
            let amount = document.querySelector(".amount").innerHTML;
            let count = document.querySelector(".count").innerHTML;
            amount = Number(amount);
            count = Number(count);

            let seat = ticket.nextElementSibling; // Sélectionner le siège associé au billet

            if (!seat.classList.contains('booked')) { // Vérifier si le siège n'est pas déjà réservé
                if (ticket.checked) {
                    count += 1;
                    amount += 200;
                } else {
                    count -= 1;
                    amount -= 200;
                }
                document.querySelector(".amount").innerHTML = amount;
                document.querySelector(".count").innerHTML = count;
            } else {
                ticket.checked = false; // Annuler la sélection si le siège est réservé
            }
        });
    });


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let form = document.getElementById('reservation-form');

        form.addEventListener('submit', function (event) {
            let count = parseInt(document.querySelector(".count").innerHTML);
            if (count === 0) {
                event.preventDefault(); // Empêcher la soumission du formulaire
                alert("Veuillez sélectionner au moins un jour avant de réserver.");
            }
        });
    });
</script>

</body>
</html>
