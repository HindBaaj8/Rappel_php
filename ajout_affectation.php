<?php
require "db.php";

$devs = $pdo->query("SELECT * FROM developpeurs")->fetchAll();
$projets = $pdo->query("SELECT * FROM projets WHERE statut='en cours'")->fetchAll();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dev = $_POST['developpeur'];
  $projet = $_POST['projet'];
  $role = $_POST['role'];

  // vérifier double affectation
  $check = $pdo->prepare("
    SELECT * FROM affections
    WHERE developpeur_id=? AND projet_id=?
  ");
  $check->execute([$dev, $projet]);

  if ($check->rowCount() > 0) {
    $message = "❌ Développeur déjà affecté à ce projet";
  } else {
    $stmt = $pdo->prepare("
      INSERT INTO affections (developpeur_id, projet_id, role)
      VALUES (?, ?, ?)
    ");
    $stmt->execute([$dev, $projet, $role]);
    header("Location: liste_affectations.php");
  }
}
?>

<h2>Ajouter affectation</h2>
<p style="color:red"><?= $message ?></p>

<form method="POST">
Développeur:
<select name="developpeur">
<?php foreach ($devs as $d): ?>
  <option value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
<?php endforeach; ?>
</select><br>

Projet (en cours):
<select name="projet">
<?php foreach ($projets as $p): ?>
  <option value="<?= $p['id'] ?>"><?= $p['titre'] ?></option>
<?php endforeach; ?>
</select><br>

Rôle:
<input name="role"><br>

<button>Valider</button>
</form>
