<?php
require 'inc/auth.php';
require 'config/database.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupération des notes
$stmt = $pdo->prepare("
    SELECT *
    FROM user_notes
    WHERE user_id = :uid
    ORDER BY created_at DESC
");
$stmt->execute(['uid' => $user_id]);
$notes = $stmt->fetchAll();

require 'templates/header.php';
?>

<h1 class="page-title">📘 Mes notes de révision</h1>

<?php if (empty($notes)): ?>
  <div class="card">
    Aucune note pour le moment.
  </div>
<?php else: ?>

  <?php foreach ($notes as $n): ?>
    <div class="card" style="text-align:left">

      <h3><?= htmlspecialchars($n['title']) ?></h3>
      <p><strong>Matière :</strong> <?= htmlspecialchars($n['matiere']) ?></p>

      <div style="margin:15px 0; white-space:pre-wrap;">
        <?= nl2br(htmlspecialchars($n['content'])) ?>
      </div>

      <div style="display:flex; gap:15px; flex-wrap:wrap">
        <a href="note_edit.php?id=<?= $n['id'] ?>">✏️ Modifier</a>
        <a href="note_download.php?id=<?= $n['id'] ?>">⬇️ Télécharger</a>
        <a href="backend/note_delete.php?id=<?= $n['id'] ?>"
           onclick="return confirm('Supprimer cette note ?')">
           🗑️ Supprimer
        </a>
      </div>

    </div>
  <?php endforeach; ?>

<?php endif; ?>

<?php require 'templates/footer.php'; ?>

