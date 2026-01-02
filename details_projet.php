<?php
require "db.php";
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM projets WHERE id=?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

$stmt2 = $pdo->prepare("
SELECT d.nom, a.role, a.date_affectation
FROM affections a
JOIN developpeurs d ON a.developpeur_id=d.id
WHERE a.projet_id=?
");
$stmt2->execute([$id]);
$devs = $stmt2->fetchAll();
?>

<h2><?= $projet['titre'] ?></h2>
<p>Type: <?= $projet['type_projet'] ?></p>
<p>Statut: <?= $projet['statut'] ?></p>
<p>Description: <?= $projet['description'] ?></p>

<h3>Développeurs affectés</h3>
<table border="1">
<tr>
  <th>Nom</th>
  <th>Rôle</th>
  <th>Date</th>
</tr>
<?php foreach ($devs as $d): ?>
<tr>
  <td><?= $d['nom'] ?></td>
  <td><?= $d['role'] ?></td>
  <td><?= $d['date_affectation'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="liste_projets.php">Retour</a>
