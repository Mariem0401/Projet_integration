<?php
session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

// Récupérer la liste des utilisateurs avec mysqli
$sql = "SELECT id, username, email, user_type, created_at FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();  // Utilisation de get_result() pour récupérer les résultats

$users = [];
while ($user = $result->fetch_assoc()) {  // Utilisation de fetch_assoc() pour récupérer chaque ligne sous forme de tableau associatif
    $users[] = $user;
}

// Ajouter un nouvel utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Crypter le mot de passe
    $user_type = $_POST['user_type'];

    $insertSql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ssss", $username, $email, $password, $user_type); // Liaison des paramètres
    $insertStmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}

// Supprimer un utilisateur
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $deleteId); // Liaison du paramètre
    $deleteStmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}

// Mettre à jour le type d'utilisateur
if (isset($_POST['update_user_type'])) {
    $userId = $_POST['user_id'];
    $userType = $_POST['user_type'];

    $updateSql = "UPDATE users SET user_type = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $userType, $userId); // Liaison des paramètres
    $updateStmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}

// Modifier les détails d'un utilisateur
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];
    $editSql = "SELECT * FROM users WHERE id = ?";
    $editStmt = $conn->prepare($editSql);
    $editStmt->bind_param("i", $editId);
    $editStmt->execute();
    $editResult = $editStmt->get_result();
    $editUser = $editResult->fetch_assoc();
}

// Mettre à jour les détails d'un utilisateur
if (isset($_POST['update_user_details'])) {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $userType = $_POST['user_type'];

    $updateDetailsSql = "UPDATE users SET username = ?, email = ?, user_type = ? WHERE id = ?";
    $updateDetailsStmt = $conn->prepare($updateDetailsSql);
    $updateDetailsStmt->bind_param("sssi", $username, $email, $userType, $userId);
    $updateDetailsStmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
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
        <a class="navbar-brand" href="admin_dashboard.php">Tableau de Bord Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="gestion_guide.php">Gestion du Guide</a> <!-- Lien vers gestion_guide.php -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container mt-5">
        <div class="container mt-5">
    <h1>Bienvenue, <?php echo $_SESSION['user_name']; ?> !</h1>
</div>
        <h1 class="text-center mb-4">Gestion des Utilisateurs</h1>

        <!-- Formulaire d'ajout d'un utilisateur -->
        <div class="card mb-4">
            <div class="card-header">
                Ajouter un nouvel utilisateur
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_type" class="form-label">Type d'utilisateur</label>
                        <select class="form-control" id="user_type" name="user_type" required>
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" name="add_user">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Liste des utilisateurs -->
        <h3>Liste des utilisateurs</h3>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Type d'utilisateur</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <select name="user_type" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="user" <?php echo ($user['user_type'] === 'user') ? 'selected' : ''; ?>>Utilisateur</option>
                                    <option value="admin" <?php echo ($user['user_type'] === 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm" name="update_user_type" style="display:none;">Mettre à jour</button>
                            </form>
                        </td>
                        <td><?php echo $user['created_at']; ?></td>
                        <td>
                            <a href="admin_dashboard.php?edit_id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="admin_dashboard.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($editUser)): ?>
            <!-- Formulaire de modification d'utilisateur -->
            <div class="card mb-4">
                <div class="card-header">
                    Modifier les informations de l'utilisateur
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $editUser['id']; ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $editUser['username']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $editUser['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_type" class="form-label">Type d'utilisateur</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="user" <?php echo ($editUser['user_type'] === 'user') ? 'selected' : ''; ?>>Utilisateur</option>
                                <option value="admin" <?php echo ($editUser['user_type'] === 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" name="update_user_details">Mettre à jour</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="mt-5 text-center">
        <p>&copy; 2024 Détection de Maladies. Tous droits réservés.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
