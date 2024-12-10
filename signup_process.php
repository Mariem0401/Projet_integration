<?php
session_start();

// Inclure le fichier de connexion à la base de données
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Vérifier que les mots de passe correspondent
    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas!";
        exit();
    }

    // Hashage du mot de passe pour plus de sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Vérifier si l'email est déjà utilisé
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Cet email est déjà utilisé!";
        exit();
    }

    // Insérer les données dans la base de données
    $user_type = 'user'; // Par défaut, un utilisateur normal

    $sql = "INSERT INTO users (username, email, password, user_type, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);
    
    if ($stmt->execute()) {
        echo "Inscription réussie!";
        // Optionnellement, rediriger l'utilisateur vers la page de connexion
        header("Location: login.php");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
