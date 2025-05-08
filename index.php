<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<section class="hero">
    <h2>Bienvenue Sur Guidi 👋</h2>
    <p>Une plateforme dédiée à la création et au partage de guides pratiques pour aider les personnes en situation de handicap.</p>
</section>

<form method="GET" style="margin-bottom: 1rem;">
    <label for="categorie">Catégorie :</label>
    <select name="categorie" id="categorie">
        <option value="">-- Toutes --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= ($categorie_actuelle ?? '') === $cat ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="recherche">Mot-Clé :</label>
    <input type="text" name="recherche" id="recherche" value="<?= $categorie_actuelle = $_GET['categorie'] ?? null;
    $recherche = $_GET['recherche'] ?? null;

    $query = "SELECT * FROM guides WHERE 1=1";
    $params = [];

    if ($categorie_actuelle) {
        $query .= " AND categorie = ?";
        $params[] = $categorie_actuelle;
    }

    if ($recherche) {
        $query .= " AND (titre LIKE ? OR contenu LIKE ?)";
        $params[] = "%$recherche%";
        $params[] = "%$recherche%";
    }

    $query .= " ORDER BY date_creation DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $guides = $stmt->fetchAll();
    ?>" placeholder="ex : clavier, Windows...">

    <button type="submit">Rechercher</button>
</form>

<section class="categories">
    <h3>🗂️ Explorer Par Catégorie</h3>
    <div class="category-list">
        <?php
        $cat_stmt = $pdo->query("SELECT DISTINCT categorie FROM guides ORDER BY categorie ASC");
        $categories = $cat_stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($categories as $cat): ?>
            <a class="cat-card" href="index.php?categorie=<?= urlencode($cat) ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="last-guides">
    <h3>🆕 Derniers Guides Ajoutés</h3>
    <?php
    $stmt = $pdo->query("SELECT * FROM guides ORDER BY date_creation DESC LIMIT 5");
    $guides = $stmt->fetchAll();

    if (count($guides) > 0): ?>
        <ul>
            <?php foreach ($guides as $guide): ?>
                <li>
                    <a href="guide.php?id=<?= $guide['id'] ?>"><?= htmlspecialchars($guide['titre']) ?><button type="submit">🗂️ Guides</button></a>
                    <a href="modifier_guide.php?id=<?= $guide['id'] ?>"><button type="submit">✏️ Modifier</button></a>
                    <a href="supprimer_guide.php?id=<?= $guide['id'] ?>"><button type="submit">🗑️ Supprimer</button></a>
                    <span class="guide-meta">(<?= htmlspecialchars($guide['categorie']) ?>)</span>   
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun Guide Publié Pour Le Moment.</p>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
