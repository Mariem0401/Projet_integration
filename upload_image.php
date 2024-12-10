<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Gestion du téléchargement d'image
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Vérification de l'extension et de la taille
        $allowed = ['jpg', 'jpeg', 'png'];
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed)) {
            if ($file_size <= 5 * 1024 * 1024) { // Limite de 5 MB
                // Déplacer le fichier vers un dossier de stockage
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true); // Créer le dossier s'il n'existe pas
                }

                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Redirection vers le script d'analyse ou confirmation
                    $_SESSION['uploaded_image'] = $upload_path;
                    header("Location: analyze_image.php?image=" . urlencode($new_file_name));
                    exit();
                } else {
                    $error = "Une erreur est survenue lors du téléchargement de l'image.";
                }
            } else {
                $error = "Le fichier est trop volumineux. (Maximum : 5 MB)";
            }
        } else {
            $error = "Format de fichier non supporté. Seuls JPG, JPEG et PNG sont autorisés.";
        }
    } else {
        $error = "Veuillez sélectionner une image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger une Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Soumettre une Image</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="upload_image.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Sélectionnez une image de feuille de tomate</label>
                <input class="form-control" type="file" id="image" name="image" accept=".jpg,.jpeg,.png" required>
            </div>
            <button type="submit" class="btn btn-success">Analyser l'image</button>
        </form>
        
        <div class="mt-4">
            <a href="user_dashboard.php" class="btn btn-secondary">Retour au tableau de bord</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
