<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'clients';
$username = 'root';
$password = '';

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connexion échouée : ' . $conn->connect_error]);
    exit;
}

// Vérifier si un paramètre de recherche a été envoyé
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    // Requête SQL avec une requête préparée
    $query = "SELECT id, nom, prix, image FROM produits WHERE nom LIKE ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Ajouter un joker pour la recherche
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param('s', $searchTerm);

        // Exécuter la requête
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);

            // Retourner les résultats en JSON
            echo json_encode(!empty($products) ? $products : ['message' => 'Aucun produit trouvé.']);
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'exécution de la requête.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Erreur de préparation de la requête SQL']);
    }
} else {
    echo json_encode(['error' => 'Aucun terme de recherche fourni.']);
}

$conn->close();
?>
