<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Se connecter</h2>
    <form action="index.php" method="POST">
        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
    <a href="/register.php">Création compte</a>
</body>
</html>
<?php
session_start();

// Configuration de la base de données
$pdo = new PDO('mysql:host=localhost;dbname=web-identif', 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Récupère l'utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie que l'utilisateur existe et que le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Connexion réussie ! Bienvenue, " . $user['username'];
        // Rediriger vers une page d'accueil ou tableau de bord
        // header("Location: dashboard.php");
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>
