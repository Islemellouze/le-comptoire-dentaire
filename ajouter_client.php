<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";  // Assurez-vous d'utiliser les bons identifiants
$password = "";      // Votre mot de passe pour la base de données
$dbname = "clients";  // Nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ajouter un utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $nom = $_POST['username'];  // Nom d'utilisateur
    $email = $_POST['email'];   // Email
    $mot_de_passe = $_POST['password'];  // Mot de passe
    $role = $_POST['role'];   // Rôle (admin ou user)

    // Validation basique des champs
    if (empty($nom) || empty($email) || empty($mot_de_passe) || empty($role)) {
        echo "Tous les champs doivent être remplis.";
        exit; // Terminer l'exécution du script si un champ est vide
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'email n'est pas valide.";
        exit;
    }

    // Insertion de l'utilisateur dans la base de données sans hachage du mot de passe
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $email, $mot_de_passe, $role); // Utilisation de la liaison de paramètres pour éviter les injections SQL

    if ($stmt->execute()) {
        echo "Utilisateur ajouté avec succès!";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur. Veuillez réessayer.";
    }

    $stmt->close(); // Fermeture de la déclaration préparée
}

$conn->close(); // Fermeture de la connexion à la base de données
?>
