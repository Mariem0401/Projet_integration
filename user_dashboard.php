<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur à partir de la session
$username = $_SESSION['user_name'];
$user_type = $_SESSION['user_type']; // "user" ou "admin"
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord de l'utilisateur</title>
    <!-- Ajouter Bootstrap et Font Awesome pour les icônes -->
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
        .nav-link {
            color: #28a745 !important;
        }
        .nav-link:hover {
            color: #218838 !important;
        }
        .btn {
            width: 100%;
        }
        .user-card {
            background-color: #28a745;
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">Dashboard</a>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="user-card">
                    <h4><?php echo htmlspecialchars($username); ?></h4>
                    <p>Utilisateur connecté</p>
                    <a href="user_profile.php" class="btn btn-light">Voir Profil</a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-user"></i> Profil
                            </div>
                            <div class="card-body">
                                <p>Gérer vos informations personnelles, votre mot de passe, et plus.</p>
                                <a href="user_profile.php" class="btn btn-success">Voir Profil</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-box"></i> Mes commandes
                            </div>
                            <div class="card-body">
                                <p>Consulter l'historique de vos commandes et leur statut.</p>
                                <a href="user_orders.php" class="btn btn-success">Voir mes commandes</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-cogs"></i> Paramètres
                            </div>
                            <div class="card-body">
                                <p>Personnalisez votre expérience utilisateur.</p>
                                <a href="user_settings.php" class="btn btn-success">Gérer les paramètres</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-info-circle"></i> Aide
                            </div>
                            <div class="card-body">
                                <p>Accédez à la section d'aide pour résoudre vos problèmes.</p>
                                <a href="help.php" class="btn btn-success">Consulter l'aide</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center">
            <p>&copy; 2024 MonSite. Tous droits réservés.</p>
        </footer>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
