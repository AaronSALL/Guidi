<?php include 'includes/db.php'; ?>

<?php
if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>Aucun Guide Sélectionné.</p>";
    echo "<a href='index.php'>Retour</a>";
    exit;
}

$id = intval($_GET['id']);

// Vérifier Que Le Guide Existe
$stmt = $pdo->prepare("SELECT id FROM guides WHERE id = ?");
$stmt->execute([$id]);
$exists = $stmt->fetch();

if (!$exists) {
    echo "<p style='color:red;'>Le Guide N'Existe Pas.</p>";
    echo "<a href='index.php'>Retour</a>";
    exit;  
}

// Suppression
$delete = $pdo->prepare("DELETE FROM guides WHERE id = ?");
$delete->execute([$id]);

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Guide Supprimé Avec Succès.'
];

// Redirection Vers L'Accueil
header("Location: index.php?message=supprimé");
exit;
