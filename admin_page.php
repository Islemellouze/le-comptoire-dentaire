<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    // Si l'utilisateur n'est pas un admin, rediriger vers la page de connexion
    header("Location: connexion.html");
    exit();
}


if (isset($_SESSION['nom'])) {
    echo "<p>Bienvenue, " . $_SESSION['nom'] . " ! Vous êtes connecté en tant qu'administrateur.</p>";
} else {
    echo "<script>alert('bienvenue.');
        window.location.href='siteadmin.html';</script>";
    }
    
// Ajouter ici les fonctionnalités spécifiques à l'administration
?>
