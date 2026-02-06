<?php
session_start();

// Si déjà connecté → redirection vers le site
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'templates/header.php';
?>

<div class="welcome-container">
  <h1>🎓 Bienvenue sur <span>MonCampus+</span></h1>

  <p class="welcome-subtitle">
    Toute votre vie académique, centralisée en un seul endroit.
  </p>

  <div class="welcome-actions">
    <a href="register.php" class="btn-primary">Créer un compte</a>
    <a href="login.php" class="btn-secondary">Se connecter</a>
  </div>

  <div class="welcome-donation">
    <p>💙 Soutenez le projet MonCampus+</p><br><br>
	<strong >Wave :</strong>  77 380 51 52
  </div>
</div>

<?php require 'templates/footer.php'; ?>
