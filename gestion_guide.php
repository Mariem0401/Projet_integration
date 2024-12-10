<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ajouter une maladie (CRUD - Créer)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_disease'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $solution = $_POST['solution'];
    $image_url = $_POST['image_url'];

    // Insérer la nouvelle maladie dans la base de données
    $sql = "INSERT INTO tomato_diseases (name, description, solution, image_url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $description, $solution, $image_url);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Maladie ajoutée avec succès!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'ajout de la maladie.</div>";
    }
}

// Modifier une maladie (CRUD - Mettre à jour)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_disease'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $solution = $_POST['solution'];
    $image_url = $_POST['image_url'];

    // Mettre à jour la maladie dans la base de données
    $sql = "UPDATE tomato_diseases SET name = ?, description = ?, solution = ?, image_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $description, $solution, $image_url, $id);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Maladie mise à jour avec succès!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour de la maladie.</div>";
    }
}

// Supprimer une maladie (CRUD - Supprimer)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Supprimer la maladie de la base de données
    $sql = "DELETE FROM tomato_diseases WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Maladie supprimée avec succès!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression de la maladie.</div>";
    }
}

// Récupérer les maladies existantes (CRUD - Lire)
$sql = "SELECT * FROM tomato_diseases";
$stmt = $conn->query($sql);
$maladies = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Maladies - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Tableau de Bord Admin</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestion des Maladies des Tomates</h1>

        <!-- Formulaire d'ajout d'une nouvelle maladie -->
        <h3>Ajouter une nouvelle maladie</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom de la maladie</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="solution" class="form-label">Solution</label>
                <textarea class="form-control" id="solution" name="solution" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">URL de l'image (facultatif)</label>
                <input type="text" class="form-control" id="image_url" name="image_url">
            </div>
            <button type="submit" class="btn btn-success" name="add_disease">Ajouter la maladie</button>
        </form>

        <hr>

        <!-- Liste des maladies existantes -->
        <h3>Liste des maladies</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Solution</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($maladies as $maladie): ?>
                <tr>
                    <td><?php echo $maladie['id']; ?></td>
                    <td><?php echo htmlspecialchars($maladie['name']); ?></td>
                    <td><?php echo htmlspecialchars(substr($maladie['description'], 0, 50)) . '...'; ?></td>
                    <td><?php echo htmlspecialchars(substr($maladie['solution'], 0, 50)) . '...'; ?></td>
                    <td>
                        <!-- Modifier -->
                        <a href="gestion_guide.php?edit_id=<?php echo $maladie['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <!-- Supprimer -->
                        <a href="gestion_guide.php?delete_id=<?php echo $maladie['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette maladie ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Modifier une maladie (pré-remplir le formulaire avec les anciennes données)
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql = "SELECT * FROM tomato_diseases WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $maladie = $result->fetch_assoc();
        ?>
        <div class="container mt-5">
            <h3>Modifier la maladie "<?php echo htmlspecialchars($maladie['name']); ?>"</h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $maladie['id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la maladie</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($maladie['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($maladie['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="solution" class="form-label">Solution</label>
                    <textarea class="form-control" id="solution" name="solution" rows="4" required><?php echo htmlspecialchars($maladie['solution']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">URL de l'image (facultatif)</label>
                    <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($maladie['image_url']); ?>">
                </div>
                <button type="submit" class="btn btn-warning" name="update_disease">Mettre à jour la maladie</button>
            </form>
        </div>
        <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
