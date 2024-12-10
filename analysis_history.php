<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Veuillez vous connecter pour accéder à l'historique des analyses.";
    exit();
}

include('db_connect.php');

// Récupérer l'historique des analyses pour l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM analysis_history WHERE user_id = ? ORDER BY analysis_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Analyses</title>
    <!-- Ajouter Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table img {
            border-radius: 8px;
        }
        .table-container {
            margin-top: 50px;
        }
        .table-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container table-container">
    <div class="card p-4">
        <h1 class="table-title">Historique des Analyses</h1>
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Maladie Détectée</th>
                    <th>Confiance (%)</th>
                    <th>Date de l'Analyse</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <img src="<?php echo $row['image_path']; ?>" alt="Image analysée" width="100" height="100">
                        </td>
                        <td><?php echo htmlspecialchars($row['disease_detected']); ?></td>
                        <td><?php echo htmlspecialchars($row['confidence']); ?>%</td>
                        <td><?php echo $row['analysis_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Ajouter Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
