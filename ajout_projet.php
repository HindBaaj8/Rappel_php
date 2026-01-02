<?php
require "db.php";

// récupérer technologies
$techs = $pdo->query("SELECT * FROM technologies")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("
    INSERT INTO projets (titre, type_projet, date_debut, date_fin, description)
    VALUES (?, ?, ?, ?, ?)
  ");
  $stmt->execute([
    $_POST['titre'],
    $_POST['type_projet'],
    $_POST['date_debut'],
    $_POST['date_fin'],
    $_POST['description']
  ]);

  $projet_id = $pdo->lastInsertId();

  foreach ($_POST['technologies'] as $tech) {
    $pdo->prepare("
      INSERT INTO projet_technologie (projet_id, technologie_id)
      VALUES (?, ?)
    ")->execute([$projet_id, $tech]);
  }

  header("Location: liste_projets.php");
}
?>

<form method="POST">
Titre: <input name="titre"><br>
Type: <input name="type_projet"><br>
Date début: <input type="date" name="date_debut"><br>
Date fin: <input type="date" name="date_fin"><br>
Description: <textarea name="description"></textarea><br>

Technologies:
<select name="technologies[]" multiple>
<?php foreach ($techs as $t): ?>
  <option value="<?= $t['id'] ?>"><?= $t['nom'] ?></option>
<?php endforeach; ?>
</select><br>

<button>Enregistrer</button>
</form>
