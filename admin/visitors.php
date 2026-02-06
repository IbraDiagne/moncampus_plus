<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn() || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require '../templates/header.php';

$visits = $pdo->query("
    SELECT v.*, u.email
    FROM visits v
    LEFT JOIN users u ON v.user_id = u.id
    ORDER BY v.visit_start DESC
    LIMIT 50
")->fetchAll();
?>

<h1 class="page-title">📊 Visiteurs récents</h1>

<table class="admin-table">
  <tr>
    <th>Utilisateur</th>
    <th>IP</th>
    <th>Page</th>
    <th>Début</th>
    <th>Durée (s)</th>
  </tr>

  <?php foreach ($visits as $v): ?>
  <tr>
    <td><?= htmlspecialchars($v['email'] ?? 'Visiteur') ?></td>
    <td><?= $v['ip_address'] ?></td>
    <td><?= htmlspecialchars($v['page']) ?></td>
    <td><?= $v['visit_start'] ?></td>
    <td><?= $v['duration'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<?php require '../templates/footer.php'; ?>
