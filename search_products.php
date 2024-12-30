<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'clients';
$username = 'root';
$password = '';

// Connexion à la base de données avec MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifiez si la connexion a échoué
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connexion échouée: ' . $conn->connect_error]);
    exit;
}

// Vérifiez si un paramètre de recherche a été envoyé
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    // Requête SQL pour trouver les produits correspondant au nom
    $query = "SELECT id, nom, prix, image FROM produits WHERE nom LIKE ?";
    $stmt = $conn->prepare($query);

    // Vérification de l'échec de la préparation de la requête
    if ($stmt === false) {
        echo json_encode(['error' => 'Erreur de préparation de la requête SQL']);
        exit;
    }

    // Ajout du caractère joker pour une recherche partielle
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param('s', $searchTerm);

    // Exécution de la requête
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $products = [];

        // Vérification de l'existence de produits
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        // Si des produits ont été trouvés, on les retourne, sinon on renvoie un message de "Aucun résultat"
        if (count($products) > 0) {
            echo json_encode($products);
        } else {
            echo json_encode(['message' => 'Aucun produit trouvé.']);
        }
    } else {
        // Si l'exécution échoue, afficher une erreur
        echo json_encode(['error' => 'Erreur lors de l\'exécution de la requête.']);
    }

    $stmt->close();
} else {
    // Si aucun terme de recherche n'est fourni, renvoyer un message d'erreur
    echo json_encode(['error' => 'Aucun terme de recherche fourni.']);
}

$conn->close();
?>
