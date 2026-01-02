<?php
require "db.php";

if (!isset($_GET['id'])) die("ID non spécifié");
$id = $_GET['id'];

if (isset($_POST['confirmer'])) {
    $pdo->prepare("DELETE FROM developpeurs WHERE id=?")->execute([$id]);
    header("Location: liste_developpeurs.php");
    exit;
}

$stmt = $pdo->prepare("SELECT nom FROM developpeurs WHERE id=?");
$stmt->execute([$id]);
$dev = $stmt->fetch();
?>

<h2>Supprimer <?= $dev['nom'] ?> ?</h2>
<form method="POST">
    <button type="submit" name="confirmer">Oui, supprimer</button>
    <a href="liste_developpeurs.php">Annuler</a>
</form>
