<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Veuillez vous connecter pour accéder aux conseils.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conseils pour la Culture des Tomates</title>
    <!-- Inclure Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .tip-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .tip-title {
            color: #007bff;
        }
        .icon {
            font-size: 2rem;
            margin-right: 10px;
            color: #28a745;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Conseils pour la Culture des Tomates</h1>

    <div class="row">
        <!-- Conseil 1 -->
        <div class="col-md-6">
            <div class="card tip-card p-4">
                <div class="d-flex align-items-center">
                    <i class="icon bi bi-seedling"></i>
                    <h4 class="tip-title">Choisir un Bon Emplacement</h4>
                </div>
                <p class="mt-3">Plantez vos tomates dans un endroit ensoleillé qui reçoit au moins 6-8 heures de lumière par jour. Assurez-vous que le sol est bien drainé.</p>
            </div>
        </div>

        <!-- Conseil 2 -->
        <div class="col-md-6">
            <div class="card tip-card p-4">
                <div class="d-flex align-items-center">
                    <i class="icon bi bi-water"></i>
                    <h4 class="tip-title">Arrosage Régulier</h4>
                </div>
                <p class="mt-3">Arrosez régulièrement, surtout par temps sec, mais évitez de mouiller les feuilles pour prévenir les maladies fongiques.</p>
            </div>
        </div>

        <!-- Conseil 3 -->
        <div class="col-md-6">
            <div class="card tip-card p-4">
                <div class="d-flex align-items-center">
                    <i class="icon bi bi-flower"></i>
                    <h4 class="tip-title">Utiliser un Paillage</h4>
                </div>
                <p class="mt-3">Appliquez un paillage autour de la base des plants pour conserver l'humidité et réduire les mauvaises herbes.</p>
            </div>
        </div>

        <!-- Conseil 4 -->
        <div class="col-md-6">
            <div class="card tip-card p-4">
                <div class="d-flex align-items-center">
                    <i class="icon bi bi-bug"></i>
                    <h4 class="tip-title">Surveiller les Ravageurs</h4>
                </div>
                <p class="mt-3">Inspectez régulièrement vos plants pour détecter les signes de ravageurs tels que les pucerons et les chenilles. Utilisez des méthodes biologiques pour les contrôler.</p>
            </div>
        </div>

        <!-- Conseil 5 -->
        <div class="col-md-6">
            <div class="card tip-card p-4">
                <div class="d-flex align-items-center">
                    <i class="icon bi bi-shield-check"></i>
                    <h4 class="tip-title">Prévenir les Maladies</h4>
                </div>
                <p class="mt-3">Faites une rotation des cultures chaque année et espacez bien les plants pour améliorer la circulation de l'air et réduire les risques de maladies.</p>
            </div>
        </div>

        <!-- Conseil 6 -->
        <div class="col-md-6">
            <div class="card tip-card p-4">
                <div class="d-flex align-items-center">
                    <i class="icon bi bi-brightness-high"></i>
                    <h4 class="tip-title">Fertilisation Adaptée</h4>
                </div>
                <p class="mt-3">Utilisez un engrais équilibré riche en potassium et en phosphore pour favoriser une bonne croissance et une meilleure production de fruits.</p>
            </div>
        </div>
    </div>
</div>

<!-- Inclure Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inclure les icônes Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>
</html>