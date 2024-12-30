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
    die(json_encode(['error' => 'Connexion échouée : ' . $conn->connect_error]));
}

// Vérifier si une catégorie est spécifiée
$category = isset($_GET['category']) ? $_GET['category'] : 'tous-les-produits';

if ($category === 'tous-les-produits') {
    $query = "SELECT * FROM produits";
    $result = $conn->query($query);

    if ($result) {
        $products = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($products);
    } else {
        echo json_encode(['error' => 'Erreur lors de l\'exécution de la requête.']);
    }
} else {
    // Requête SQL avec une requête préparée
    $query = "SELECT * FROM produits WHERE categorie = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $category);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode(!empty($products) ? $products : []);
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'exécution de la requête.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Erreur de préparation de la requête SQL']);
    }
}

$conn->close();
?>
