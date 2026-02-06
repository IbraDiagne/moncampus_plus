<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../inc/track_visit.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin    = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MonCampus+</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/moncampus/assets/images/logo-moncampus.png">

  <link rel="stylesheet" href="/moncampus/assets/css/style.css">


<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>



</head>

<body>

<header>
  <nav class="navbar">

    <div class="logo">
     <div class="nav-brand">
      <img src="/moncampus/assets/images/logo-moncampus.png" alt="MonCampus+" class="site-logo">
      <span class="site-title"><a href="/moncampus/index.php">MonCampus+</a></span>
     </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
      <form action="/moncampus/search.php" method="GET" class="nav-search">
        <input
          type="text"
          name="q"
          placeholder="Rechercher (cours, notes, fichiers...)"
          required
        >
      </form>
     <?php endif; ?>

    <ul class="nav-links">

      <?php if (!in_array($currentPage, ['login.php', 'register.php'])): ?>
        <li><a href="/moncampus/index.php">Accueil</a></li>
      <?php endif; ?>

      <?php if ($isLoggedIn): ?>

        <li class="welcome-user">
          👋 Bonjour <?= htmlspecialchars($_SESSION['user_prenom']) ?>
        </li>

        <li><a href="/moncampus/dashboard.php">Dashboard</a></li>

       <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li><a href="/moncampus/admin/index.php">Admin</a></li>
        <?php endif; ?>

        <li><a href="/moncampus/upload.php">Ajouter un fichier</a></li>
        <li><a href="/moncampus/logout.php">Déconnexion</a></li>

      <?php else: ?>
        <li><a href="/moncampus/login.php">Connexion</a></li>
        <li><a href="/moncampus/register.php">Inscription</a></li>
      <?php endif; ?>

    </ul>
  </nav>
</header>

<main class="container page">
