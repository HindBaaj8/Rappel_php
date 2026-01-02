<?php
require "db.php";


$projets = $pdo->query("SELECT id, titre FROM projets")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $specialite = $_POST['specialite'];
    $image = $_POST['image']; 
    $projet_id = $_POST['projet'];
    $role = $_POST['role'];

    
    $stmt = $pdo->prepare("INSERT INTO developpeurs (nom, email, mot_de_passe, specialite, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $email, $mot_de_passe, $specialite, $image]);

    $dev_id = $pdo->lastInsertId();

    if (!empty($projet_id)) {
        $stmt2 = $pdo->prepare("INSERT INTO affections (developpeur_id, projet_id, role) VALUES (?, ?, ?)");
        $stmt2->execute([$dev_id, $projet_id, $role]);
    }

    header("Location: liste_developpeurs.php");
    exit;
}
?>

<h2>Ajouter un développeur</h2>
<form method="POST">
    <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br>
    <input type="text" name="specialite" placeholder="Spécialité"><br>
    <input type="text" name="image" placeholder="URL image"><br>

    <select name="projet">
        <option value="">-- Projet --</option>
        <?php foreach ($projets as $p): ?>
            <option value="<?= $p['id'] ?>"><?= $p['titre'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="text" name="role" placeholder="Rôle dans le projet"><br>

    <button type="submit">Enregistrer</button>
</form>
