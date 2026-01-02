<?php
require "db.php";

$sql = "
SELECT p.id, p.titre, p.type_projet, p.statut, p.date_fin,
       COUNT(a.developpeur_id) AS nb_devs
FROM projets p
LEFT JOIN affections a ON p.id = a.projet_id
GROUP BY p.id
";

$stmt = $pdo->query($sql);
$projets = $stmt->fetchAll();
?>

<h2>Liste des projets</h2>

<table border="1">
<tr>
  <th>Titre</th>
  <th>Type</th>
  <th>Statut</th>
  <th>Date fin</th>
  <th>Nb développeurs</th>
  <th>Actions</th>
</tr>

<?php foreach ($projets as $p): ?>
<tr>
  <td><?= $p['titre'] ?></td>
  <td><?= $p['type_projet'] ?></td>
  <td><?= $p['statut'] ?></td>
  <td><?= $p['date_fin'] ?></td>
  <td><?= $p['nb_devs'] ?></td>
  <td>
    <a href="details_projet.php?id=<?= $p['id'] ?>">Détails</a>
    <a href="modifier_projet.php?id=<?= $p['id'] ?>">Modifier</a>
    <a href="supprimer_projet.php?id=<?= $p['id'] ?>">Supprimer</a>
  </td>
</tr>
<?php endforeach; ?>
</table>

<a href="ajout_projet.php">Ajouter projet</a>
