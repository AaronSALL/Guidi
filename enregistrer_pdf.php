<?php
require 'vendor/autoload.php';
include 'includes/db.php';

use Dompdf\Dompdf;

// Vérifier L'ID
if (!isset($_GET['id'])) {
    echo "Aucun Guide Sélectionné.";
    exit;
}

$id = (int) $_GET['id'];

// Récupérer Le Guide
$stmt = $pdo->prepare("SELECT * FROM guides WHERE id = ?");
$stmt->execute([$id]);
$guide = $stmt->fetch();

if (!$guide) {
    echo "Guide Introuvable.";
    exit;
}

// Contenu HTML à Convertir
$html = "
<h1>{$guide['titre']}</h1>
<p><strong>Catégorie :</strong> {$guide['categorie']}</p>
<p><strong>Date :</strong> {$guide['date_creation']}</p>
<hr>
<p>" . nl2br(htmlspecialchars($guide['contenu'])) . "</p>
";

// Générer PDF Avec Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("guide_{$id}.pdf", ["Attachment" => true]);
exit;
