<?php
require 'inc/auth.php';
require 'config/database.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

require 'templates/header.php';

// Récupération des tâches
$stmt = $pdo->prepare("
    SELECT *
    FROM todo_tasks
    WHERE user_id = :uid
    ORDER BY status, priority DESC, due_date ASC
");
$stmt->execute(['uid' => $user_id]);
$todos = $stmt->fetchAll();
?>

<h1 class="page-title">📝 Mon planning de révision</h1>

<!-- FORMULAIRE AJOUT -->
<form action="backend/todo_add.php" method="POST" class="auth-box">

  <h3>➕ Ajouter une tâche</h3>

  <input type="text" name="title" placeholder="Ex: Réviser chapitre 3" required>

  <select name="type" required>
    <option value="">Type</option>
    <option value="cours">Cours</option>
    <option value="tdtp">TD / TP</option>
    <option value="khints">Khints</option>
    <option value="revision">Révision générale</option>
  </select>

  <input type="text" name="matiere" placeholder="Matière" required>

  <select name="priority">
    <option value="low">Faible</option>
    <option value="medium">Moyenne</option>
    <option value="high">Haute</option>
  </select>

  <input type="date" name="due_date">

  <button type="submit">Ajouter</button>
</form>

<hr>

<!-- LISTE DES TÂCHES -->
<div class="cards">
<?php if (!$todos): ?>
  <p>Aucune tâche pour le moment.</p>
<?php endif; ?>

<?php foreach ($todos as $t): ?>
  <div class="card <?= $t['status'] === 'done' ? 'done' : '' ?>">
    <strong><?= htmlspecialchars($t['title']) ?></strong><br>
    <?= htmlspecialchars($t['matiere']) ?> • <?= $t['type'] ?><br>
    Priorité : <?= $t['priority'] ?><br>
    Date : <?= $t['due_date'] ?? '—' ?>

    <div style="margin-top:10px;">
      <?php if ($t['status'] === 'todo'): ?>
        <a href="backend/todo_done.php?id=<?= $t['id'] ?>">✅ Terminé</a>

	<a href="backend/todo_delete.php?id=<?= $t['id'] ?>"
   		onclick="return confirm('Supprimer cette tâche ?')"
   		style="color:red;">
   		🗑 Supprimer
	</a>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php require 'templates/footer.php'; ?>
