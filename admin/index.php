<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require '../templates/header.php';
?>

<h1 class="page-title">📊 Statistiques du site</h1>

<?php
$total = $pdo->query("SELECT COUNT(*) FROM visits")->fetchColumn();
$users = $pdo->query("SELECT COUNT(DISTINCT user_id) FROM visits WHERE user_id IS NOT NULL")->fetchColumn();
$pages = $pdo->query("
    SELECT page, COUNT(*) total
    FROM visits
    GROUP BY page
    ORDER BY total DESC
    LIMIT 5
")->fetchAll();
?>

<div class="cards">
  <div class="card">👥 Visites totales : <strong><?= $total ?></strong></div>
  <div class="card">🔐 Utilisateurs connectés : <strong><?= $users ?></strong></div>
</div>

<h2 class="page-subtitle">📄 Pages les plus visitées</h2>

<div class="cards">
<?php foreach ($pages as $p): ?>
  <div class="card">
    <?= htmlspecialchars($p['page']) ?><br>
    <small><?= $p['total'] ?> visites</small>
  </div>
<?php endforeach; ?>
</div>

<h2 class="page-subtitle">🕒 Dernières visites</h2>

<?php
$visits = $pdo->query("
    SELECT v.*, u.email
    FROM visits v
    LEFT JOIN users u ON v.user_id = u.id
    ORDER BY v.visited_at DESC
    LIMIT 20
")->fetchAll();
?>

<div class="cards">
<?php foreach ($visits as $v): ?>
  <div class="card">
    👤 <?= $v['email'] ?? 'Visiteur' ?><br>
    📄 <?= $v['page'] ?><br>
    ⏱️ <?= $v['duration'] ?> sec<br>
    🕒 <?= $v['visited_at'] ?>
  </div>
<?php endforeach; ?>
</div>

<?php require '../templates/footer.php'; ?>
