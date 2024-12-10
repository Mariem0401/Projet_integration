<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Détection de Maladies des Tomates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .card-header {
            background-color: #28a745;
            color: white;
            font-size: 1.25rem;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            width: 100%;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">Détection des Maladies</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="user_dashboard.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-4">Bienvenue, <?php echo htmlspecialchars($username); ?> !</h1>
        <div class="row">
            <!-- Section pour l'historique des analyses et conseils agricoles -->
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-history"></i> Historique des analyses
                            </div>
                            <div class="card-body text-center">
                                <p>Consultez les résultats de vos analyses précédentes.</p>
                                <a href="analysis_history.php" class="btn btn-success">Voir l'historique</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-leaf"></i> Conseils agricoles
                            </div>
                            <div class="card-body text-center">
                                <p>Apprenez comment prendre soin de vos cultures pour éviter les maladies.</p>
                                <a href="tips.php" class="btn btn-success">Voir les conseils</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section pour télécharger une image en dessous à droite -->
            <div class="col-md-6 mb-4 d-flex justify-content-end">
            <div class="card shadow-sm">
                    <div class="card-header">
                        <i class="fas fa-bell"></i> Guide
                    </div>
                    <div class="card-body text-center">
                        <p>Restez informé des alertes et des nouvelles importantes.</p>
                        <a href="guide.php" class="btn btn-success">Voir le Guide</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Section pour les alertes et mises à jour -->
            <div class="col-md-12 mb-4">
              
                <div class="card shadow-sm">
                    <div class="card-header">
                        <i class="fas fa-camera"></i> Soumettre une image
                    </div>
                    <div class="card-body text-center">
                        <p>Soumettez une image des feuilles de tomates pour détecter une maladie.</p>
                        <a href="upload_image.php" class="btn btn-success">Télécharger une image</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 text-center">
        <p>&copy; 2024 Détection de Maladies. Tous droits réservés.</p>
    </footer>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
