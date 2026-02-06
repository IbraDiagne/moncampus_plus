<?php
require 'inc/auth.php';
require 'config/database.php';

if (!isLoggedIn()) exit;

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM user_notes
    WHERE id = :id AND user_id = :uid
");
$stmt->execute([
    'id'  => $id,
    'uid' => $_SESSION['user_id']
]);

$note = $stmt->fetch();

if (!$note) {
    die("Note introuvable.");
}

require 'templates/header.php';
?>

<h1 class="page-title">✏️ Modifier la note</h1>

<form action="backend/note_update.php" method="POST" class="auth-box">
  <input type="hidden" name="id" value="<?= $note['id'] ?>">

  <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>
  <input type="text" name="matiere" value="<?= htmlspecialchars($note['matiere']) ?>" required>

  <textarea name="content" rows="8" required><?= htmlspecialchars($note['content']) ?></textarea>

  <button type="submit">💾 Enregistrer</button>
</form>

<?php require 'templates/footer.php'; ?>
