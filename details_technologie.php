<?php
require "db.php";

if (!isset($_GET['id'])) die("ID non spécifié");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM technologies WHERE id = ?");
$stmt->execute([$id]);
$tech = $stmt->fetch();

$stmt2 = $pdo->prepare("
    SELECT p.titre, p.statut
    FROM projets p
    JOIN projet_technologie pt ON p.id = pt.projet_id
    WHERE pt.technologie_id = ?
");
$stmt2->execute([$id]);
$projets = $stmt2->fetchAll();
?>

<h1>Détails de la technologie: <?=$tech['nom'] ?></h1>
<p>Description: <?= $tech['description']?></p>

<h2>Projets utilisant cette technologie</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Titre</th>
        <th>Statut</th>
    </tr>
    <?php foreach ($projets as $p): ?>
    <tr>
        <td><?= $p['titre'] ?></td>
        <td><?= $p['statut'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="liste_technologie.php">Retour</a>
<a href="modifier_technologie.php?id=<?= $tech['id'] ?>">Modifier</a>
<a href="supprimer_technologie.php?id=<?= $tech['id'] ?>">Supprimer</a>
