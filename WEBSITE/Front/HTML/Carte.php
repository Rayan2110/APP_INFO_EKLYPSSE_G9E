<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

$is_admin = ($_SESSION['pseudo'] === "root");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_membres";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}

$event_name = isset($_GET['event_name']) ? $_GET['event_name'] : '';

$evenement_id = null;
$map = null;
$capteurs = [];

if (!empty($event_name)) {
    $event_name = htmlspecialchars($event_name);

    $query = "SELECT e.id as evenement_id, c.id as carte_id, c.map_image 
              FROM evenements e 
              JOIN cartes_evenements c ON e.id = c.evenement_id 
              WHERE e.nom = :event_name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $evenement_id = $result['evenement_id'];
        $map = ['id' => $result['carte_id'], 'map_image' => $result['map_image']];

        $capteurs_query = "SELECT * FROM capteurs WHERE carte_evenement_id = :carte_id";
        $capteurs_stmt = $conn->prepare($capteurs_query);
        $capteurs_stmt->bindParam(':carte_id', $map['id'], PDO::PARAM_INT);
        $capteurs_stmt->execute();
        $capteurs = $capteurs_stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Événement ou carte non trouvé.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carte de l'Événement</title>
    <link rel="stylesheet" href="../CSS/carte.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="content-container">
        <div class="left-panel">
            <h1>Recherche d'Événement</h1>
            <form action="carte.php" method="get">
                <label for="event_name">Nom de l'Événement:</label>
                <input type="text" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event_name ?? ''); ?>" required>
                <button type="submit">Rechercher</button>
            </form>

            <?php if (!empty($event_name) && $evenement_id && $map): ?>
                <h1>Carte de l'Événement</h1>
                <div id="map-container" style="position: relative;">
                    <img id="festival-map" src="<?php echo $map['map_image']; ?>" alt="Carte de l'événement">
                    <div id="info-box" class="info-box"></div>
                </div>
                <?php if ($is_admin): ?>
                    <button id="add-sensor">Ajouter un capteur</button>
                    <button id="save-changes">Enregistrer les Modifications</button>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="right-panel">
            <div class="average-info">
                <div id="current-average">
                    <h3>Moyenne dB actuelle</h3>
                    <p id="current-average-value">0 dB</p>
                </div>
                <div id="overall-average">
                    <h3>Moyenne dB de la scène</h3>
                    <p id="overall-average-value">0 dB</p>
                </div>
            </div>

            <h2>Informations des Capteurs</h2>
            <div id="capteurs-info">
                <?php if (is_array($capteurs) && count($capteurs) > 0): ?>
                    <?php foreach ($capteurs as $capteur): ?>
                        <div class="sensor-info" data-sensor-id="<?php echo $capteur['id']; ?>">
                            <p>Capteur ID: <?php echo $capteur['id']; ?></p>
                            <p>Niveau Sonore: <?php echo $capteur['sound_level']; ?> dB</p>
                            <p>Coordonnées: (<?php echo $capteur['x_coordinate']; ?>%, <?php echo $capteur['y_coordinate']; ?>%)</p>
                            <?php if ($is_admin): ?>
                                <button class="remove-sensor" data-sensor-id="<?php echo $capteur['id']; ?>">✖</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun capteur trouvé.</p>
                <?php endif; ?>
            </div>

            <div style="display: flex; align-items: center;">
                <div id="color-scale"></div>
                <div id="color-scale-labels">
                    <span>10 dB</span>
                    <span>20 dB</span>
                    <span>40 dB</span>
                    <span>60 dB</span>
                    <span>80 dB</span>
                    <span>100 dB</span>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
document.addEventListener('DOMContentLoaded', (event) => {
    const mapContainer = document.getElementById('map-container');
    const festivalMap = document.getElementById('festival-map');
    const addSensorButton = document.getElementById('add-sensor');
    const saveChangesButton = document.getElementById('save-changes');
    const infoBox = document.getElementById('info-box');
    let capteurs = <?php echo json_encode($capteurs); ?>;
    const mapWidth = festivalMap.width;
    const mapHeight = festivalMap.height;

    let newCapteurs = [];
    let addSensorMode = false;

    // Fetch the initial overall average from the server or set initial values
    let overallSum = <?php echo $overall_sum ?? 0; ?>;
    let overallCount = <?php echo $overall_count ?? 0; ?>;
    updateOverallAverageDisplay();

    function fetchLatestSoundLevels() {
        fetch('get_latest_sound_levels.php?evenement_id=<?php echo $evenement_id; ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    capteurs = data.capteurs;
                    updateSensorDisplay();
                    updateSoundLevels();
                    placeSensorDots();
                    updateCurrentAverage();
                } else {
                    console.error('Fetch error:', data.message);
                }
            })
            .catch(error => console.error('Fetch error:', error));
    }

    function updateSensorDisplay() {
        const capteursInfo = document.getElementById('capteurs-info');
        capteursInfo.innerHTML = '';
        capteurs.forEach(capteur => {
            const sensorDiv = document.createElement('div');
            sensorDiv.classList.add('sensor-info');
            sensorDiv.dataset.sensorId = capteur.id; // Add sensor ID to the div for reference
            sensorDiv.innerHTML = `<p>Capteur ID: ${capteur.id}</p>
                                <p>Niveau Sonore: ${capteur.sound_level} dB</p>
                                <p>Coordonnées: (${capteur.x_coordinate}%, ${capteur.y_coordinate}%)</p>
                                <?php if ($is_admin): ?>
                                    <button class="remove-sensor" data-sensor-id="${capteur.id}">✖</button>
                                <?php endif; ?>`;
            capteursInfo.appendChild(sensorDiv);

            // Add hover effect
            sensorDiv.addEventListener('mouseover', () => highlightSensor(capteur.id));
            sensorDiv.addEventListener('mouseout', () => removeHighlightSensor(capteur.id));
            // Add click event for remove button if admin
            <?php if ($is_admin): ?>
                sensorDiv.querySelector('.remove-sensor').addEventListener('click', (e) => {
                    e.stopPropagation();
                    const sensorId = e.target.dataset.sensorId;
                    if (confirm('Voulez-vous vraiment supprimer ce capteur ?')) {
                        removeSensor(sensorId);
                    }
                });
            <?php endif; ?>
        });
    }

    function placeSensorDots() {
        document.querySelectorAll('.sensor-dot').forEach(dot => dot.remove());
        capteurs.forEach(capteur => {
            const dot = document.createElement('div');
            dot.classList.add('sensor-dot');
            dot.dataset.sensorId = capteur.id; // Add sensor ID to the dot for reference
            dot.style.left = `${capteur.x_coordinate}%`;
            dot.style.top = `${capteur.y_coordinate}%`;
            mapContainer.appendChild(dot);
        });
    }

    function highlightSensor(sensorId) {
        document.querySelectorAll(`.sensor-dot[data-sensor-id="${sensorId}"]`).forEach(dot => {
            dot.classList.add('highlight');
        });
    }

    function removeHighlightSensor(sensorId) {
        document.querySelectorAll(`.sensor-dot[data-sensor-id="${sensorId}"]`).forEach(dot => {
            dot.classList.remove('highlight');
        });
    }

    function updateSoundLevels() {
        const canvas = document.createElement('canvas');
        canvas.width = mapWidth;
        canvas.height = mapHeight;
        const ctx = canvas.getContext('2d');

        const imageData = ctx.createImageData(canvas.width, canvas.height);
        const data = imageData.data;

        const sigma = 85;

        for (let y = 0; y < canvas.height; y++) {
            for (let x = 0; x < canvas.width; x++) {
                const index = (y * canvas.width + x) * 4;
                const color = getColorForSoundLevel(0);
                data[index] = color[0];
                data[index + 1] = color[1];
                data[index + 2] = color[2];
                data[index + 3] = 255;
            }
        }

        for (let y = 0; y < canvas.height; y++) {
            for (let x = 0; x < canvas.width; x++) {
                let totalSound = 0;
                if (capteurs.length > 0) {
                    capteurs.forEach(capteur => {
                        const dx = x - (capteur.x_coordinate / 100 * canvas.width);
                        const dy = y - (capteur.y_coordinate / 100 * canvas.height);
                        const distanceSquared = dx * dx + dy * dy;
                        const gaussianFactor = Math.exp(-distanceSquared / (2 * sigma * sigma));
                        const soundContribution = Math.pow(10, capteur.sound_level / 10) * gaussianFactor;
                        totalSound += soundContribution;
                    });
                }

                const totalSoundInDb = 10 * Math.log10(totalSound);

                const color = getColorForSoundLevel(totalSoundInDb);
                const index = (y * canvas.width + x) * 4;
                data[index] = color[0];
                data[index + 1] = color[1];
                data[index + 2] = color[2];
                data[index + 3] = 255;
            }
        }

        ctx.putImageData(imageData, 0, 0);
        mapContainer.style.backgroundImage = `url(${canvas.toDataURL()})`;

        updateCurrentAverage(canvas);
    }

    function getColorForSoundLevel(soundLevel) {
        const colorStops = [
            { level: 0, color: [0, 128, 0] },
            { level: 20, color: [173, 255, 47] },
            { level: 40, color: [255, 215, 0] },
            { level: 60, color: [255, 140, 0] },
            { level: 80, color: [255, 69, 0] }
        ];

        for (let i = 0; i < colorStops.length - 1; i++) {
            const currentStop = colorStops[i];
            const nextStop = colorStops[i + 1];
            if (soundLevel >= currentStop.level && soundLevel < nextStop.level) {
                const t = (soundLevel - currentStop.level) / (nextStop.level - currentStop.level);
                return interpolateColor(currentStop.color, nextStop.color, t);
            }
        }

        return [0, 128, 0];
    }

    function interpolateColor(color1, color2, t) {
        return [
            Math.round(color1[0] + (color2[0] - color1[0]) * t),
            Math.round(color1[1] + (color2[1] - color1[1]) * t),
            Math.round(color1[2] + (color2[2] - color1[2]) * t)
        ];
    }

    function updateCurrentAverage(canvas) {
        const ctx = canvas.getContext('2d');
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;

        let totalPower = 0;
        let count = 0;

        for (let y = 0; y < canvas.height; y++) {
            for (let x = 0; x < canvas.width; x++) {
                const index = (y * canvas.width + x) * 4;
                const r = data[index];
                const g = data[index + 1];
                const b = data[index + 2];

                if (r !== 0 || g !== 128 || b !== 0) { // Skip initial green pixels
                    const power = Math.pow(10, (getDbFromColor(r, g, b) / 10));
                    totalPower += power;
                    count++;
                }
            }
        }

        const averagePower = totalPower / count;
        const currentAverageDb = 10 * Math.log10(averagePower);

        document.getElementById('current-average-value').innerText = `${currentAverageDb.toFixed(2)} dB`;

        // Update overall average based on current average
        updateOverallAverage(currentAverageDb);
    }

    function getDbFromColor(r, g, b) {
        const colorStops = [
            { level: 0, color: [0, 128, 0] },
            { level: 20, color: [173, 255, 47] },
            { level: 40, color: [255, 215, 0] },
            { level: 60, color: [255, 140, 0] },
            { level: 80, color: [255, 69, 0] }
        ];

        for (let i = 0; i < colorStops.length - 1; i++) {
            const currentStop = colorStops[i];
            const nextStop = colorStops[i + 1];
            if (arraysEqual([r, g, b], currentStop.color)) {
                return currentStop.level;
            }
            if (arraysEqual([r, g, b], nextStop.color)) {
                return nextStop.level;
            }
            if (r > currentStop.color[0] && r < nextStop.color[0] &&
                g > currentStop.color[1] && g < nextStop.color[1] &&
                b > currentStop.color[2] && b < nextStop.color[2]) {
                const t = (r - currentStop.color[0]) / (nextStop.color[0] - currentStop.color[0]);
                return currentStop.level + t * (nextStop.level - currentStop.level);
            }
        }

        return 0; // Default dB level for initial green color
    }

    function arraysEqual(arr1, arr2) {
        if (arr1.length !== arr2.length) return false;
        for (let i = 0; i < arr1.length; i++) {
            if (arr1[i] !== arr2[i]) return false;
        }
        return true;
    }

    function updateOverallAverage(newDbValue) {
        overallSum += newDbValue;
        overallCount++;
        const overallAverage = (overallCount > 0) ? overallSum / overallCount : 0;
        document.getElementById('overall-average-value').innerText = `${overallAverage.toFixed(2)} dB`;
    }

    function updateOverallAverageDisplay() {
        const overallAverage = (overallCount > 0) ? overallSum / overallCount : 0;
        document.getElementById('overall-average-value').innerText = `${overallAverage.toFixed(2)} dB`;
    }

    function addSensor(x, y) {
        const rect = festivalMap.getBoundingClientRect();
        const xPercent = ((x - rect.left) / rect.width) * 100;
        const yPercent = ((y - rect.top) / rect.height) * 100;
        const newCapteur = { x_coordinate: xPercent, y_coordinate: yPercent, sound_level: 0 };  // Niveau sonore par défaut
        newCapteurs.push(newCapteur);
        capteurs.push(newCapteur);
        updateSensorDisplay();
        placeSensorDots();
        updateSoundLevels();
        updateCurrentAverage();
        updateOverallAverage(0);  // Initial value is 0
    }

    function removeSensor(sensorId) {
        fetch('remove_capteur.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: sensorId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                capteurs = capteurs.filter(capteur => capteur.id != sensorId);
                updateSensorDisplay();
                placeSensorDots();
                updateSoundLevels();
                updateCurrentAverage();
                alert('Capteur supprimé avec succès.');
            } else {
                alert('Erreur lors de la suppression du capteur.');
            }
        })
        .catch(error => console.error('Erreur:', error));
    }

    document.addEventListener('click', (e) => {
        if (!mapContainer.contains(e.target)) {
            infoBox.style.display = 'none';
        }
    });

    festivalMap.addEventListener('click', (e) => {
        e.stopPropagation();
        if (!addSensorMode) {
            const rect = festivalMap.getBoundingClientRect();
            const xPercent = ((e.clientX - rect.left) / rect.width) * 100;
            const yPercent = ((e.clientY - rect.top) / rect.height) * 100;
            let soundLevel = getEstimatedSoundLevel(xPercent, yPercent);

            if (soundLevel < 10) soundLevel = 10;

            infoBox.style.left = `${e.clientX + 10}px`;
            infoBox.style.top = `${e.clientY + 10}px`;
            infoBox.innerText = `Estimated Sound Level: ${soundLevel.toFixed(2)} dB`;
            infoBox.style.display = 'block';
        } else {
            addSensor(e.clientX, e.clientY);
            addSensorMode = false; // Disable add sensor mode after adding a sensor
            festivalMap.classList.remove('crosshair-cursor'); // Remove crosshair cursor after adding a sensor
        }
    });

    <?php if ($is_admin): ?>
        addSensorButton.addEventListener('click', (e) => {
            e.stopPropagation();
            addSensorMode = true; // Enable add sensor mode when button is clicked
            festivalMap.classList.add('crosshair-cursor'); // Add crosshair cursor when button is clicked
        });

        saveChangesButton.addEventListener('click', (e) => {
            e.stopPropagation();
            fetch('save_capteurs.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ capteurs: newCapteurs })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Capteurs ajoutés avec succès.');
                    newCapteurs.forEach(capteur => {
                        updateOverallAverage(capteur.sound_level);
                    });
                    newCapteurs = [];  // Réinitialiser après l'enregistrement
                } else {
                    alert('Erreur lors de l\'ajout des capteurs.');
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    <?php endif; ?>

    function getEstimatedSoundLevel(xPercent, yPercent) {
        const canvas = document.createElement('canvas');
        canvas.width = mapWidth;
        canvas.height = mapHeight;
        const ctx = canvas.getContext('2d');

        const sigma = 85;
        let totalSound = 0;

        if (capteurs.length > 0) {
            capteurs.forEach(capteur => {
                const dx = (xPercent / 100 * canvas.width) - (capteur.x_coordinate / 100 * canvas.width);
                const dy = (yPercent / 100 * canvas.height) - (capteur.y_coordinate / 100 * canvas.height);
                const distanceSquared = dx * dx + dy * dy;
                const gaussianFactor = Math.exp(-distanceSquared / (2 * sigma * sigma));
                const soundContribution = Math.pow(10, capteur.sound_level / 10) * gaussianFactor;
                totalSound += soundContribution;
            });
        }

        const estimatedSoundInDb = 10 * Math.log10(totalSound);
        return estimatedSoundInDb;
    }

    function update() {
        fetchLatestSoundLevels();
        setTimeout(update, 300);  // Adjust the update frequency as needed
    }

    update();
});
</script>
</body>
</html>
