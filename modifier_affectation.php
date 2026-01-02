<?php
require "db.php";
$id = $_GET['id'];

$aff = $pdo->prepare("SELECT * FROM affections WHERE id=?");
$aff->execute([$id]);
$aff = $aff->fetch();

$projets = $pdo->query("SELECT * FROM projets WHERE statut='en cours'")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $projet = $_POST['projet'];
  $role = $_POST['role'];

  $pdo->prepare("
    UPDATE affections SET projet_id=?, role=?
    WHERE id=?
  ")->execute([$projet, $role, $id]);

  header("Location: liste_affectations.php");
}
?>

<form method="POST">
Projet:
<select name="projet">
<?php foreach ($projets as $p): ?>
  <option value="<?= $p['id'] ?>" <?= $p['id']==$aff['projet_id']?'selected':'' ?>>
    <?= $p['titre'] ?>
  </option>
<?php endforeach; ?>
</select><br>

Rôle:
<input name="role" value="<?= $aff['role'] ?>"><br>

<button>Modifier</button>
</form>
