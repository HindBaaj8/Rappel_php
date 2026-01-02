<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $desc = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO technologies (nom, description) VALUES (?, ?)");
    $stmt->execute([$nom, $desc]);

    header("Location: liste_technologie.php");
    exit;
}
?>

<h1>Ajouter une technologie</h1>

<form method="POST">
    <label>Nom:</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <button type="submit">Enregistrer</button>
</form>
