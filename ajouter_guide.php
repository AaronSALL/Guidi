<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<h2>Ajouter Un Nouveau Guide</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = htmlspecialchars($_POST['titre']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $contenu = htmlspecialchars($_POST['contenu']);

    $stmt = $pdo->prepare("INSERT INTO guides (titre, categorie, contenu) VALUES (?, ?, ?)");
    $stmt->execute([$titre, $categorie, $contenu]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Guide Ajouté Avec Succès !'
    ];
    header("Location: index.php");
    exit;    
}
?>

<form method="POST">
    <label for="titre">Titre Du Guide :</label><br>
    <input type="text" name="titre" id="titre" required><br><br>

    <label for="categorie">Catégorie :</label><br>
    <input type="text" name="categorie" id="categorie" placeholder="Ex: Informatique, Mécanique..." required><br><br>

    <label for="contenu">Contenu Du Guide :</label><br>
    <textarea name="contenu" id="contenu" rows="10" cols="60" required></textarea><br><br>

    <button type="submit">Enregistrer</button>
</form>

<?php include 'includes/footer.php'; ?>
