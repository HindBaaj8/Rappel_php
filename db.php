<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=gestion_projets;charset=utf8mb4",
        "root",
        ""
    );
    } catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
