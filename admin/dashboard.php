<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isAdmin()) {
    die("Accès refusé");
}

// Stats
$totalVisits = $pdo->query("SELECT COUNT(*) FROM visits")->fetchColumn();
$uniqueVisitors = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visits")->fetchColumn();
$totalTime = $pdo->query("SELECT SUM(duration) FROM sessions_stats")->fetchColumn();
$avgRating = $pdo->query("SELECT AVG(rating) FROM ratings")->fetchColumn();
?>

<h1>📊 Dashboard Admin</h1>

<ul>
  <li>👀 Visites totales : <?= $totalVisits ?></li>
  <li>🧍 Visiteurs uniques : <?= $uniqueVisitors ?></li>
  <li>⏱ Temps total passé : <?= round($totalTime / 60) ?> min</li>
  <li>⭐ Note moyenne : <?= number_format($avgRating, 2) ?>/5</li>
</ul>
