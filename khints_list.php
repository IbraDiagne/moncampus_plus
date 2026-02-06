<?php
require 'config/database.php';

$type     = $_GET['type']     ?? '';
$filiere  = $_GET['filiere']  ?? '';
$semestre = $_GET['semestre'] ?? '';
$matiere  = $_GET['matiere']  ?? '';

if (
    !in_array($type, ['cc', 'ds']) ||
    $filiere === '' ||
    $semestre === '' ||
    $matiere === ''
) {
    header("Location: index.php");
    exit;
}

require 'templates/header.php';

// Récupération des fichiers
$sql = "
SELECT id, original_name, filename, uploaded_at
FROM files
WHERE type = 'khints'
  AND filiere = :filiere
  AND semestre = :semestre
  AND matiere = :matiere
  AND filename LIKE :subtype
ORDER BY uploaded_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'filiere'  => $filiere,
    'semestre' => $semestre,
    'matiere'  => $matiere,
    'subtype'  => "%$type%"
]);

$files = $stmt->fetchAll();
?>

<div class="container page">

  <h1 class="page-title">💡 Khints <?= strtoupper($type) ?></h1>
  <p class="page-subtitle"><?= htmlspecialchars($matiere) ?></p>

  <div class="cards">

    <?php if (empty($files)): ?>
      <div class="card">Aucun khints disponible.</div>
    <?php else: ?>
      <?php foreach ($files as $file): ?>
        <a class="card"
           href="uploads/khints/<?= $type ?>/<?= htmlspecialchars($file['filename']) ?>"
           target="_blank">
          📄 <?= htmlspecialchars($file['original_name']) ?>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>

  <div class="back-link">
    <a href="khints.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>&matiere=<?= urlencode($matiere) ?>">
      ← Retour Khints
    </a>
  </div>

</div>

<?php include 'templates/footer.php'; ?>
