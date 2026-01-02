<?php
require "db.php";

$statut = $_GET['statut'] ?? "";

$sql = "
SELECT a.id,
       d.nom AS developpeur,
       p.titre AS projet,
       p.statut,
       a.date_affectation
FROM affections a
JOIN developpeurs d ON a.developpeur_id = d.id
JOIN projets p ON a.projet_id = p.id
";

if ($statut != "") {
  $sql .= " WHERE p.statut = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$statut]);
} else {
  $stmt = $pdo->query($sql);
}

$affectations = $stmt->fetchAll();
?>

<h2>Liste des affectations</h2>

<form method="GET">
  <select name="statut">
    <option value="">-- Statut projet --</option>
    <option value="en cours">En cours</option>
    <option value="termine">Terminé</option>
    <option value="en attente">En attente</option>
  </select>
  <button>Filtrer</button>
</form>

<table border="1">
<tr>
  <th>Développeur</th>
  <th>Projet</th>
  <th>Statut</th>
  <th>Date affectation</th>
  <th>Actions</th>
</tr>

<?php foreach ($affectations as $a): ?>
<tr>
  <td><?= $a['developpeur'] ?></td>
  <td><?= $a['projet'] ?></td>
  <td><?= $a['statut'] ?></td>
  <td><?= $a['date_affectation'] ?></td>
  <td>
    <a href="modifier_affectation.php?id=<?= $a['id'] ?>">Modifier</a>
    <a href="supprimer_affectation.php?id=<?= $a['id'] ?>">Supprimer</a>
  </td>
</tr>
<?php endforeach; ?>
</table>

<a href="ajout_affectation.php">Nouvelle affectation</a>
