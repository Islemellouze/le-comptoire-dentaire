<div id="products-grid">
<?php
// Configuration de la base de données
$host = 'localhost'; // Hôte
$dbname = 'clients'; // Nom de la base de données
$username = 'root'; // Utilisateur
$password = ''; // Mot de passe (vide pour localhost)

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer tous les produits de la base de données
$sql = "SELECT * FROM produits";
$result = $conn->query($sql);

// Vérifier si des produits sont disponibles
if ($result->num_rows > 0) {
    // Récupérer les produits sous forme de tableau associatif
    $produits = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $produits = []; // Si aucun produit n'est trouvé
}
header('Location: site.html');
    exit();

// Fermer la connexion
$conn->close();
?>


</div>
