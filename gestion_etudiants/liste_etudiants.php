<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <script>
        // Fonction de confirmation avant suppression
        function confirmerSuppression(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?")) {
                // Redirection vers la page de suppression avec l'ID en paramètre
                window.location.href = "supprimer_etudiant.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <h1>Liste des Étudiants</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'gestion_etudiants');

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Récupération des étudiants dans la base
        $result = $conn->query("SELECT * FROM etudiants");

        // Vérification si des données existent
        if ($result->num_rows > 0) {
            // Parcourir et afficher les données
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nom']}</td>
                        <td>{$row['prenom']}</td>
                        <td>{$row['email']}</td>
                        <td><button onclick='confirmerSuppression({$row['id']})'>Supprimer</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun étudiant trouvé.</td></tr>";
        }

        // Fermeture de la connexion
        $conn->close();
        ?>
    </table>
</body>
</html>
