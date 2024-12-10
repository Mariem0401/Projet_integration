<?php
// Définir les informations de connexion à la base de données
$servername = "localhost";
$username = "root"; // Nom d'utilisateur pour la base de données
$password = ""; // Mot de passe pour la base de données
$dbname = "tomato_detection"; // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {

    die("Échec de la connexion : " . $conn->connect_error);
}

// Si la connexion est réussie, on continue l'exécution du script
?>
