<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestion_etudiants');

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];

// Protection contre les injections SQL (optionnel mais recommandé)
$nom = $conn->real_escape_string($nom);
$prenom = $conn->real_escape_string($prenom);
$email = $conn->real_escape_string($email);

// Insertion des données dans la base
$sql = "INSERT INTO etudiants (nom, prenom, email) VALUES ('$nom', '$prenom', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Étudiant ajouté avec succès.');
            window.location.href='index.html';
          </script>";
} else {
    echo "<script>
            alert('Erreur : " . $sql . " - " . $conn->error . "');
            window.location.href='index.html';
          </script>";
}

// Fermeture de la connexion
$conn->close();
?>
