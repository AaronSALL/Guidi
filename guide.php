<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>Aucun guide sélectionné.</p>";
    include 'includes/footer.php';
    exit;
}

$id = intval($_GET['id']); // Sécurisation De Base

$stmt = $pdo->prepare("SELECT * FROM guides WHERE id = ?");
$stmt->execute([$id]);
$guide = $stmt->fetch();

if (!$guide) {
    echo "<p style='color:red;'>Ce Guide N'Existe Pas.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<h2><?= htmlspecialchars($guide['titre']) ?></h2>
<p><strong>Catégorie :</strong> <?= htmlspecialchars($guide['categorie']) ?></p>
<p><strong>Date :</strong> <?= $guide['date_creation'] ?></p>

<hr>

<p><?= nl2br(htmlspecialchars($guide['contenu'])) ?></p>

<br>
<a href="enregistrer_pdf.php?id=<?= $guide['id'] ?>"><button type="submit">📄 Enregistrer En PDF</button></a>

<?php include 'includes/footer.php'; ?>
