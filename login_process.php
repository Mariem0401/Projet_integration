<?php
session_start();

// Inclure le fichier de connexion à la base de données
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT id, username, email, password, user_type FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Utilisateur trouvé, vérifier le mot de passe
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Authentification réussie, démarrer la session et rediriger
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type']; // admin ou user

            // Rediriger selon le type d'utilisateur
            if ($row['user_type'] === 'admin') {
                header("Location: admin_dashboard.php"); // Page tableau de bord admin
            } else {
                header("Location: user_dashboard.php"); // Page tableau de bord utilisateur classique
            }
            exit();
        } else {
            echo "Mot de passe incorrect!";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email!";
    }

    $stmt->close();
    $conn->close();
}
?>
