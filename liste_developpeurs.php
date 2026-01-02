<?php
require "db.php";


$stmt2 = $pdo->query("SELECT id, titre FROM projets");
$projets = $stmt2->fetchAll();

if (!empty($_GET['nom']) && !empty($_GET['projet'])) {
    $stmt = $pdo->prepare("
        SELECT d.id, d.nom, d.specialite, COUNT(a.projet_id) AS nb_projets
        FROM developpeurs d
        JOIN affections a ON d.id = a.developpeur_id
        WHERE d.nom LIKE ? AND a.projet_id = ?
        GROUP BY d.id
    ");
    $stmt->execute(["%".$_GET['nom']."%", $_GET['projet']]);
} elseif (!empty($_GET['nom'])) {
    $stmt = $pdo->prepare("
        SELECT d.id, d.nom, d.specialite, COUNT(a.projet_id) AS nb_projets
        FROM developpeurs d
        LEFT JOIN affections a ON d.id = a.developpeur_id
        WHERE d.nom LIKE ?
        GROUP BY d.id
    ");
    $stmt->execute(["%".$_GET['nom']."%"]);
} elseif (!empty($_GET['projet'])) {
    $stmt = $pdo->prepare("
        SELECT d.id, d.nom, d.specialite, COUNT(a.projet_id) AS nb_projets
        FROM developpeurs d
        JOIN affections a ON d.id = a.developpeur_id
        WHERE a.projet_id = ?
        GROUP BY d.id
    ");
    $stmt->execute([$_GET['projet']]);
} else {
    $stmt = $pdo->query("
        SELECT d.id, d.nom, d.specialite, COUNT(a.projet_id) AS nb_projets
        FROM developpeurs d
        LEFT JOIN affections a ON d.id = a.developpeur_id
        GROUP BY d.id
    ");
}

$developpeurs = $stmt->fetchAll();
?>
<form method="GET">
  <input type="text" name="nom" placeholder="Nom du développeur">
  <select name="projet">
    <option value="">-- Projet --</option>
    <?php foreach ($projets as $p): ?>
      <option value="<?= $p['id'] ?>"><?= $p['titre'] ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Filtrer</button>
</form>

<table border="1">
<tr>
  <th>Nom</th>
  <th>Spécialité</th>
  <th>Nombre Projets</th>
  <th>Actions</th>
</tr>
<?php foreach ($developpeurs as $d): ?>
<tr>
  <td><?= $d['nom'] ?></td>
  <td><?= $d['specialite'] ?></td>
  <td><?= $d['nb_projets'] ?></td>
  <td>
    <a href="details_developpeur.php?id=<?= $d['id'] ?>">Détails</a>
    <a href="modifier_developpeur.php?id=<?= $d['id'] ?>">Modifier</a>
    <a href="supprimer_developpeur.php?id=<?= $d['id'] ?>">Supprimer</a>

  </td>
</tr>
<?php endforeach; ?>
</table>
<a href="ajout_developpeur.php">Ajouter developpeur</a>
