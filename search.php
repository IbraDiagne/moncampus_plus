<?php
session_start();
require 'config/database.php';
require 'templates/header.php';

$q = trim($_GET['q'] ?? '');

if ($q === '') {
    echo "<p class='page-subtitle'>Veuillez entrer un mot clé.</p>";
    require 'templates/footer.php';
    exit;
}

$sql = "
SELECT *
FROM files
WHERE status = 'active'
AND (
    matiere LIKE :q
    OR original_name LIKE :q
    OR filiere LIKE :q
    OR type LIKE :q
)
ORDER BY uploaded_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['q' => "%$q%"]);
$results = $stmt->fetchAll();
?>

<div class="container page">
  <h1 class="page-title">🔍 Résultats pour « <?= htmlspecialchars($q) ?> »</h1>

  <?php if (empty($results)): ?>
    <p class="page-subtitle">Aucun résultat trouvé.</p>
  <?php else: ?>
    <div class="cards">
      <?php foreach ($results as $file): ?>
        <div class="card">
          <strong><?= htmlspecialchars($file['original_name']) ?></strong><br>
          <small>
            <?= htmlspecialchars($file['filiere']) ?> |
            Semestre <?= htmlspecialchars($file['semestre']) ?> |
            <?= htmlspecialchars($file['type']) ?>
          </small>

          <div style="margin-top:10px;">
            <a href="/moncampus/uploads/<?= urlencode($file['filename']) ?>" target="_blank">
              📂 Ouvrir
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require 'templates/footer.php'; ?>
