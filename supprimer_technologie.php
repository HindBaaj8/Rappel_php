<?php
require "db.php";

if (!isset($_GET['id'])) die("ID non spécifié");
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM technologies WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: liste_technologie.php");
    exit;
}
?>

<h1>Supprimer la technologie?</h1>
<form method="POST">
    <button type="submit">Confirmer la suppression</button>
    <a href="liste_technologie.php">Annuler</a>
</form>
