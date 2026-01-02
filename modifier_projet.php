<?php
require "db.php";
$id = $_GET['id'];

$projet = $pdo->prepare("SELECT * FROM projets WHERE id=?");
$projet->execute([$id]);
$projet = $projet->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo->prepare("
    UPDATE projets SET titre=?, type_projet=?, date_debut=?, date_fin=?, description=?
    WHERE id=?
  ")->execute([
    $_POST['titre'],
    $_POST['type_projet'],
    $_POST['date_debut'],
    $_POST['date_fin'],
    $_POST['description'],
    $id
  ]);

  header("Location: liste_projets.php");
}
?>

<form method="POST">
<input name="titre" value="<?= $projet['titre'] ?>"><br>
<input name="type_projet" value="<?= $projet['type_projet'] ?>"><br>
<input type="date" name="date_debut" value="<?= $projet['date_debut'] ?>"><br>
<input type="date" name="date_fin" value="<?= $projet['date_fin'] ?>"><br>
<textarea name="description"><?= $projet['description'] ?></textarea><br>
<button>Modifier</button>
</form>
