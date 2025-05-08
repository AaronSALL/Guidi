<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        require 'includes/db.php';

        // Hachage Du Mot De Passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion En Base De Données
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);

        echo "Utilisateur créé Avec Succès !";
    } else {
        echo "Veuillez Remplir Tous Les Champs.";
    }
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Connexion Réussie.'
        ];
        header("Location: index.php");
        exit;
    } else {
        $error = "❌ Identifiants Incorrects.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>🔐 Connexion</h2>

<?php if ($error): ?>
    <div class="flash error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <label>Nom D'Utilisateur</label>
    <input type="text" name="username" required>

    <label>Mot De Passe</label>
    <input type="password" name="password" required>

    <button type="submit">Se Connecter</button>
</form>

<?php include 'includes/footer.php'; ?>
