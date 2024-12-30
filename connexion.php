<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'clients');

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérification si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = trim($_POST['email']);
    $Mot_de_passe = $_POST['password'];

    // Validation des champs
    if (empty($Email) || empty($Mot_de_passe)) {
        echo "<script>alert('Veuillez remplir tous les champs.');
        window.location.href='connexion.html';</script>";
        exit;
    }

    // Validation de l'email (filtrage)
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email invalide.');
        window.location.href='connexion.html';</script>";
        exit;
    }

    // Recherche de l'utilisateur dans la base de données
    $sql = $conn->prepare("SELECT Mot_de_passe, role FROM utilisateurs WHERE Email = ?");
    $sql->bind_param("s", $Email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $stored_password = $user['Mot_de_passe'];
        $role = $user['role'];

        // Vérification du mot de passe sans hachage
        if ($Mot_de_passe === $stored_password) {
            // Démarrer une session
            session_start();
            $_SESSION['email'] = $Email;
            $_SESSION['role'] = $role;

            // Filtrage et redirection selon le rôle
            if ($role === 'admin') {
                header("Location: admin_page.php");
                exit();
            } elseif ($role === 'user') {
                header("Location: user.php");
                exit();
            } else {
                echo "<script>alert('Rôle inconnu.');
                window.location.href='connexion.html';</script>";
            }
        } else {
            echo "<script>alert('Mot de passe incorrect.');
            window.location.href='connexion.html';</script>";
        }
    } else {
        echo "<script>alert('Aucun compte trouvé avec cet email.');
        window.location.href='connexion.html';</script>";
    }

    $sql->close();
}

$conn->close();
?>
