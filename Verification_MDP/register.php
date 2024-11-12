<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h2>Créer un compte</h2>
    <form action="register.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
<?php
// Configuration de la base de données
$pdo = new PDO('mysql:host=localhost;dbname=web-identif', 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash du mot de passe

    // Vérifie si l'email est déjà enregistré
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insère l'utilisateur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $password])) {
            echo "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        } else {
            echo "Erreur lors de la création du compte.";
        }
    }
}
?>
