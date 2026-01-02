<?php
require "db.php";
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo->prepare("DELETE FROM projets WHERE id=?")->execute([$id]);
  header("Location: liste_projets.php");
}
?>

<form method="POST">
  <p>Confirmer suppression ?</p>
  <button>Oui</button>
  <a href="liste_projets.php">Non</a>
</form>
