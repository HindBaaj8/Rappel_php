<?php
require "db.php";

if (!isset($_GET['id'])) die("ID non spécifié");
$id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM developpeurs WHERE id = ?");
$stmt->execute([$id]);
$dev = $stmt->fetch();
if (!$dev) die("Développeur non trouvé");


$projets = $pdo->query("SELECT id, titre FROM projets")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $specialite = $_POST['specialite'];
    $image = $_POST['image'];

    $stmt = $pdo->prepare("UPDATE developpeurs SET nom=?, email=?, specialite=?, image=? WHERE id=?");
    $stmt->execute([$nom, $email, $specialite, $image, $id]);

    header("Location: liste_developpeurs.php");
    exit;
}
?>

<h2>Modifier <?= $dev['nom'] ?></h2>
<form method="POST">
    <input type="text" name="nom" value="<?= $dev['nom'] ?>" required><br>
    <input type="email" name="email" value="<?= $dev['email'] ?>" required><br>
    <input type="text" name="specialite" value="<?= $dev['specialite'] ?>"><br>
    <input type="text" name="image" value="<?= $dev['image'] ?>"><br>
    <button type="submit">Modifier</button>
</form>
