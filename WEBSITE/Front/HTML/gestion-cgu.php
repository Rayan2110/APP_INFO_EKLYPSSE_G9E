<?php
session_start();
if($_SESSION['pseudo'] !== "root"){
    header('Location: forbidden.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/gestion-cgu.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Téléchargement et téléversement de fichiers</title>
</head>
<body>
<?php
// Inclure le fichier header.php
include 'header.php';
?>
<br>
<br>
<a href="admin.php" class="Admin" style="text-align:center;color:black; text-decoration: none;"><h1>Admin</h1></a>
    <div class="container mt-5">
        <h2>Téléverser un fichier</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file_cgu" class="form-label">Conditions générales d'utilisation (CGU)</label>
                <input type="file" class="form-control" name="file_cgu" id="file_cgu">
            </div>
            <div class="mb-3">
                <label for="file_mentions_legales" class="form-label">Mentions légales</label>
                <input type="file" class="form-control" name="file_mentions_legales" id="file_mentions_legales">
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: orange;border:none">Téléverser les fichiers</button>
        </form>

        <?php
        // Paramètres de connexion à la base de données
        $db_host = "localhost";
        $db_name = "fileuploaddownload";
        $db_user = "root";
        $db_pass = "";

        try {
            // Connexion à la base de données avec PDO
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            // Définir le mode d'erreur PDO à exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si un fichier a été téléversé
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Vérifier si un fichier CGU a été téléversé
                if (isset($_FILES["file_cgu"]) && $_FILES["file_cgu"]["error"] == 0) {
                    $target_dir = "uploads/";
                    $target_file_cgu = $target_dir . "CGU.pdf";
                    move_uploaded_file($_FILES["file_cgu"]["tmp_name"], $target_file_cgu);
                    echo "Le fichier CGU a été téléversé avec succès.";
                }
                // Vérifier si un fichier Mentions légales a été téléversé
                if (isset($_FILES["file_mentions_legales"]) && $_FILES["file_mentions_legales"]["error"] == 0) {
                    $target_dir = "uploads/";
                    $target_file_mentions_legales = $target_dir . "MentionsLegales.pdf";
                    move_uploaded_file($_FILES["file_mentions_legales"]["tmp_name"], $target_file_mentions_legales);
                    echo "Le fichier Mentions légales a été téléversé avec succès.";
                }
            }

            // Afficher les fichiers réellement présents dans le dossier "uploads"
            $uploaded_files = array_diff(scandir('uploads/'), array('..', '.'));
            if (!empty($uploaded_files)) {
                ?>
                <h2>Fichiers téléversés</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nom du fichier</th>
                        <th>Taille du fichier</th>
                        <th>Type de fichier</th>
                        <th>Heure de téléversement</th>
                        <th>Télécharger</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($uploaded_files as $file) {
                        $file_path = "uploads/" . $file;
                        $file_size = filesize("uploads/" . $file);
                        $file_type = mime_content_type("uploads/" . $file);
                        $upload_time = date("Y-m-d H:i:s", filemtime("uploads/" . $file));
                        ?>
                        <tr>
                            <td><?php echo $file; ?></td>
                            <td><?php echo $file_size; ?> octets</td>
                            <td><?php echo $file_type; ?></td>
                            <td><?php echo $upload_time; ?></td>
                            <td><a href="<?php echo $file_path; ?>" class="btn btn-primary" style="background-color: orange;border:none" download>Télécharger</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "Aucun fichier téléversé pour le moment.";
            }
        } catch(PDOException $e) {
            // En cas d'erreur de connexion, afficher le message d'erreur
            echo "Échec de la connexion : " . $e->getMessage();
        } finally {
            // Fermer la connexion PDO
            $conn = null;
        }
        ?>
    </div>
	<br>
	<br>
	<br>
	<footer>
    <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
    </footer>
</body>
</html>

