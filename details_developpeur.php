<?php
require "db.php";

if (!isset($_GET['id'])) {
    die("ID non spécifié");
}

$id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM developpeurs WHERE id = ?");
$stmt->execute([$id]);
$dev = $stmt->fetch();

if (!$dev) {
    die("Développeur non trouvé");
}

$stmt2 = $pdo->prepare("
    SELECT p.titre, p.statut, a.role, a.date_affectation
    FROM affections a
    JOIN projets p ON a.projet_id = p.id
    WHERE a.developpeur_id = ?
");
$stmt2->execute([$id]);
$projets = $stmt2->fetchAll();
?>

<h2>Détails de <?= $dev['nom'] ?></h2>
<p>Spécialité: <?= $dev['specialite'] ?></p>
<p>Email: <?= $dev['email'] ?></p>
<img src="<?= $dev['image'] ?>" alt="Photo de <?= $dev['nom'] ?>" width="150">

<h3>Projets affectés</h3>
<table border="1">
<tr>
  <th>Titre</th>
  <th>Statut</th>
  <th>Rôle</th>
  <th>Date affectation</th>
</tr>
<?php foreach ($projets as $p): ?>
<tr>
  <td><?= $p['titre'] ?></td>
  <td><?= $p['statut'] ?></td>
  <td><?= $p['role'] ?></td>
  <td><?= $p['date_affectation'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<br>
<a href="liste_developpeurs.php">Retour</a>
<a href="modifier_developpeur.php?id=<?= $dev['id'] ?>">Modifier</a>
<a href="supprimer_developpeur.php?id=<?= $dev['id'] ?>">Supprimer</a>
