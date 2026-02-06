<?php
require 'config/database.php';
require 'templates/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$file_id = (int) $_GET['id'];

// Récupération du fichier
$stmt = $pdo->prepare("
    SELECT f.*, u.prenom, u.nom
    FROM files f
    JOIN users u ON u.id = f.user_id
    WHERE f.id = :id
");
$stmt->execute(['id' => $file_id]);
$file = $stmt->fetch();

if (!$file) {
    die("Fichier introuvable");
}

// Déterminer le chemin réel
$basePath = "uploads/";

if ($file['type'] === 'khints') {
    // par défaut CC (adapter plus tard si besoin)
    $filePath = $basePath . "khints/cc/" . $file['filename'];
} else {
    $filePath = $basePath . $file['type'] . "/" . $file['filename'];
}

$extension = strtolower(pathinfo($file['original_name'], PATHINFO_EXTENSION));
?>

<div class="container page">

  <h1 class="page-title">📄 <?= htmlspecialchars($file['original_name']) ?></h1>
  <p class="page-subtitle">
    Ajouté par <?= htmlspecialchars($file['prenom']) ?>
  </p>

  <div class="content-box">

    <?php if ($extension === 'pdf'): ?>
        <!-- AFFICHAGE PDF -->
        <iframe
            src="<?= htmlspecialchars($filePath) ?>"
            width="100%"
            height="600px"
            style="border:none;">
        </iframe>

    <?php elseif (in_array($extension, ['jpg','jpeg','png'])): ?>
        <!-- AFFICHAGE IMAGE -->
        <img
            src="<?= htmlspecialchars($filePath) ?>"
            alt="Image"
            style="max-width:100%; border-radius:12px;">

    <?php else: ?>
        <p>Format non supporté pour la lecture en ligne.</p>
    <?php endif; ?>

  </div>

  <div class="nav-actions">
    <a class="btn-link" href="<?= htmlspecialchars($filePath) ?>" download>
      ⬇ Télécharger
    </a>

    <a class="btn-link" href="javascript:history.back()">
      ← Retour
    </a>
  </div>

</div>

<?php include 'templates/footer.php'; ?>
