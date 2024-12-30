<?php
session_start();

// Vérifier si l'utilisateur est connecté et n'est pas un admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    // Si l'utilisateur n'est pas un utilisateur, rediriger vers la page de connexion
    header("Location: site.html");
    exit();
}

if (isset($_SESSION['nom'])) {
    echo "<p>Bienvenue, " . $_SESSION['nom'] . " ! Vous êtes connecté en tant qu'un utilisateur </p>";
} else {
    echo "<script>alert('bienvenue.');
        window.location.href='compteutilisateur.html';</script>";
    }
?>
