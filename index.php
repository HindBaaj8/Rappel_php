<?php 
    session_start();
?>
<h2>Bienvenue <?= $_SESSION['user']['nom'] ?></h2>

<ul>
  <li><a href="liste_developpeurs.php">Gestion des développeurs</a></li>
  <li><a href="liste_projets.php">Gestion des projets</a></li>
  <li><a href="liste_technologie.php">Gestion des technologies</a></li>
  <li><a href="liste_affectations.php">Gestion des affectations</a></li>
  <li><a href="logout.php">Déconnexion</a></li>
</ul>
 