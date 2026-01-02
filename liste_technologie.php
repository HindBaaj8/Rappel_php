<?php
require "db.php";

$stmt = $pdo->query("
    SELECT t.id, t.nom,COUNT(pt.projet_id) AS nb_projets
    FROM technologies t
    LEFT JOIN projet_technologie pt ON t.id = pt.technologie_id
    GROUP BY t.id
");
$technologies = $stmt->fetchAll();
?>

<h1>Liste des Technologies</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>Nom</th>
        <th>Nombre de projets</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($technologies as $t): ?>
    <tr>
        <td><?= $t['nom'] ?></td>
        <td><?= $t['nb_projets'] ?></td>
        <td>
            <a href="details_technologie.php?id=<?= $t['id'] ?>">Détails</a> |
            <a href="modifier_technologie.php?id=<?= $t['id'] ?>">Modifier</a> |
            <a href="supprimer_technologie.php?id=<?= $t['id'] ?>">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="ajout_technologie.php">Ajouter une nouvelle technologie</a>
