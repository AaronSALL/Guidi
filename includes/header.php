<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="description" content="Guides pratiques et accessibles pour aider les personnes en situation de handicap. Informatique, Mécanique, Vie Quotidienne et Autres...">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Guidi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>📘 Guidi</h1>
        <nav>
            <ul class="navbar">
                <li><a href="index.php">🏠 Accueil</a></li>

                <?php if (!empty($_SESSION['user'])): ?>
                <li><a href="ajouter_guide.php">➕ Ajouter</a></li>
                <li><a href="logout.php">🚪 Déconnexion</a></li>
                <?php else: ?>
                <li><a href="login.php">🔐 Connexion</a></li>
                <?php endif; ?>
                <li><a href="àpropos.php">ℹ️ À Propos</a></li>
                <li><a href="contact_mentions.php">📬 Mentions Légales</a></li>
            </ul>
        </nav>
    </header>
    <main>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash <?= $_SESSION['flash']['type'] ?>">
            <?= $_SESSION['flash']['message'] ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
