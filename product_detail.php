<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clients";  // Nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Récupérer les détails du produit depuis la base de données
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="style8.css">
</head>
<body>
    <header>
        <div class="header">
            <!-- Ajoutez ici votre en-tête habituel -->
        </div>
    </header>

    <div class="product-detail">
        <?php if ($product): ?>
            <h1><?= $product['nom']; ?></h1>
            <img src="<?= $product['image']; ?>" alt="<?= $product['nom']; ?>" style="width: 300px;">
            <p><strong>Description:</strong> <?= $product['description']; ?></p>
            <p><strong>Prix:</strong> <?= $product['prix']; ?> DT</p>
            <button class="add-to-cart" 
                    data-id="<?= $product['id']; ?>" 
                    data-name="<?= $product['nom']; ?>" 
                    data-price="<?= $product['prix']; ?>" 
                    data-image="<?= $product['image']; ?>">
                Ajouter au panier
            </button>
        <?php else: ?>
            <p>Produit non trouvé.</p>
        <?php endif; ?>
    </div>

    <footer>
        <!-- Ajoutez ici votre pied de page habituel -->
    </footer>
</body>
</html>
