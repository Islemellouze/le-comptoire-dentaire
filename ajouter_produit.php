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

// Récupération des données du formulaire
$name = $_POST['product-name'];
$description = $_POST['product-description'];
$price = $_POST['product-price'];
$category = $_POST['product-category'];

// Traitement de l'image
$imagePath = '';
if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === 0) {
    $imageTmp = $_FILES['product-image']['tmp_name'];
    $imageName = $_FILES['product-image']['name'];
    $imagePath = 'uploads/' . basename($imageName);

    // Déplacer l'image téléchargée dans le dossier 'uploads'
    move_uploaded_file($imageTmp, $imagePath);
}

// Préparer la requête SQL pour insérer le produit
$stmt = $conn->prepare("INSERT INTO produits (nom, description, prix, image, categorie) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssdss", $name, $description, $price, $imagePath, $category);

// Exécuter la requête
if ($stmt->execute()) {
    // Rediriger vers la page des produits après l'ajout
    header('Location: site.php');
    exit();
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
