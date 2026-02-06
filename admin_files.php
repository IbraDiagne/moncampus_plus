<?php
require 'config/database.php';
require 'templates/header.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['user_role'] !== 'admin'
) {
    die("Accès refusé");
}

$sql = "
  SELECT f.*, u.email
  FROM files f
  JOIN users u ON u.id = f.user_id
  ORDER BY f.uploaded_at DESC
";

$stmt = $pdo->query($sql);
$files = $stmt->fetchAll();
?>

<div class="container page">

  <h1 class="page-title">🛠️ Administration des fichiers</h1>
  <p class="page-subtitle">Gestion globale</p>

  <?php if (!$files): ?>
    <p>Aucun fichier.</p>
  <?php else: ?>

    <div class="admin-table">

      <div class="admin-row admin-header">
        <div>Nom</div>
        <div>Type</div>
        <div>Matière</div>
        <div>Utilisateur</div>
        <div>Action</div>
      </div>

      <?php foreach ($files as $file): ?>
        <div class="admin-row">

          <div><?= htmlspecialchars($file['original_name']) ?></div>
          <div><?= strtoupper($file['type']) ?></div>
          <div><?= htmlspecialchars($file['matiere']) ?></div>
          <div><?= htmlspecialchars($file['email']) ?></div>

          <div>
            <form
              action="backend/delete_file.php"
              method="POST"
              onsubmit="return confirm('Supprimer ce fichier ?');"
            >
              <input type="hidden" name="id" value="<?= $file['id'] ?>">
              <button class="btn-delete">Supprimer</button>
            </form>
          </div>

        </div>
      <?php endforeach; ?>

    </div>

  <?php endif; ?>

</div>

<?php include 'templates/footer.php'; ?>
