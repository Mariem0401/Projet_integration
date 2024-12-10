<?php
session_start();
include('db_connect.php');
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Initialiser $searchTerm à une chaîne vide
$searchTerm = '';

// Vérifier si un terme de recherche a été envoyé
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Récupérer les maladies de la base de données avec ou sans recherche
$sql = "SELECT * FROM tomato_diseases WHERE name LIKE :searchTerm";
$stmt = $pdo->prepare($sql);
$stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
$diseases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide des Maladies des Tomates</title>
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
                        <a class="nav-link active" href="guide.php">Guide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Guide des Maladies des Tomates</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher une maladie" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </form>

        <?php foreach ($diseases as $disease): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <i class="fas fa-virus"></i> <?php echo htmlspecialchars($disease['name']); ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($disease['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($disease['image_url']); ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($disease['name']); ?>">
                    <?php endif; ?>
                    <h5>Description</h5>
                    <p><?php echo nl2br(htmlspecialchars($disease['description'])); ?></p>
                    <h5>Solution</h5>
                    <p><?php echo nl2br(htmlspecialchars($disease['solution'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="mt-5 text-center">
        <p>&copy; 2024 Détection de Maladies. Tous droits réservés.</p>
    </footer>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
