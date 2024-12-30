<?php
$conn = new mysqli ('localhost', 'root', '', 'gestion etudiants');
$id = $_GET['id'];
$conn->query("DELETE FROM etudiants WHERE id = $id");
echo "<script>alert ('Étudiant supprimé avec succès.');
window.location.href='liste_etudiants.php';</script>" 
?>