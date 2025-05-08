<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>Aucun Guide Sélectionné.</p>";
    include 'includes/footer.php';
    exit;
}

$id = intval($_GET['id']);

// Récupération Du Guide
$stmt = $pdo->prepare("SELECT * FROM guides WHERE id = ?");
$stmt->execute([$id]);
$guide = $stmt->fetch();

if (!$guide) {
    echo "<p style='color:red;'>Ce Guide N'Existe Pas.</p>";
    include 'includes/footer.php';
    exit;
}

// Traitement Du Formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = htmlspecialchars($_POST['titre']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $contenu = htmlspecialchars($_POST['contenu']);

    $update = $pdo->prepare("UPDATE guides SET titre = ?, categorie = ?, contenu = ? WHERE id = ?");
    $update->execute([$titre, $categorie, $contenu, $id]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Guide Mis à Jour Avec Succès.'
    ];
    header("Location: index.php");
    exit;    

    // Rafraîchir Les Données
    $stmt->execute([$id]);
    $guide = $stmt->fetch();
}
?>

<h2>Modifier Le Guide</h2>

<form method="POST">
    <label for="titre">Titre Du Guide :</label><br>
    <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($guide['titre']) ?>" required><br><br>

    <label for="categorie">Catégorie :</label><br>
    <input type="text" name="categorie" id="categorie" value="<?= htmlspecialchars($guide['categorie']) ?>" required><br><br>

    <label for="contenu">Contenu Du Guide :</label><br>
    <textarea name="contenu" id="contenu" rows="10" cols="60" required><?= htmlspecialchars($guide['contenu']) ?></textarea><br><br>

    <button type="submit">Mettre à Jour</button>
</form>

<?php include 'includes/footer.php'; ?>
