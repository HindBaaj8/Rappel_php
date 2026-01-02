<?php
require "db.php";

if (!isset($_GET['id'])) die("ID non spécifié");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM technologies WHERE id = ?");
$stmt->execute([$id]);
$tech = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $desc = $_POST['description'];

    $stmt2 = $pdo->prepare("UPDATE technologies SET nom = ?, description = ? WHERE id = ?");
    $stmt2->execute([$nom, $desc, $id]);

    header("Location: liste_technologie.php");
    exit;
}
?>

<h1>Modifier la technologie</h1>

<form method="POST">
    <label>Nom:</label><br>
    <input type="text" name="nom" value="<?= $tech['nom'] ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required><?= $tech['description'] ?></textarea><br><br>

    <button type="submit">Modifier</button>
</form>
