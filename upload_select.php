<?php
require 'inc/auth.php';
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
require 'templates/header.php';
?>

<div class="container page">
  <h1 class="page-title">Ajouter un fichier</h1>

  <div class="cards">
    <a class="card" href="upload.php?type=cours">📘 Cours</a>
    <a class="card" href="upload.php?type=tdtp">📝 TD / TP</a>
    <a class="card" href="upload.php?type=khints">💡 Khints</a>
    <a class="card" href="upload.php?type=ressources">🌍 Ressources</a>
  </div>
</div>

<?php include 'templates/footer.php'; ?>
