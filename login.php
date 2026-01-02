<?php
session_start(); // مهم جدا
require "db.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM developpeurs WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

   if ($user && $password === $user['mot_de_passe']) { 
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $message = "Email ou mot de passe incorrect";
    }
}
?>

<h2>Connexion</h2>
<p style="color:red"><?= $message ?></p>

<form method="POST">
    Email: <input type="email" name="email" required><br>
    Mot de passe: <input type="password" name="password" required><br>
    <button type="submit">Se connecter</button>
</form>
