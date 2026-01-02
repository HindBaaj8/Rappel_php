<?php
require "db.php";
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo->prepare("DELETE FROM affections WHERE id=?")->execute([$id]);
  header("Location: liste_affectations.php");
}
?>

<form method="POST">
  <p>Confirmer la suppression ?</p>
  <button>Oui</button>
  <a href="liste_affectations.php">Non</a>
</form>
