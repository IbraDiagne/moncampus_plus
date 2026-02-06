<?php require 'templates/header.php'; ?>

<main class="auth-page page">
  <div class="auth-box">
    <h2>Créer un compte</h2>

<form action="/moncampus/backend/register_process.php" method="POST">

  <input type="text" name="nom" placeholder="Nom" required>
  <input type="text" name="prenom" placeholder="Prénom" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Mot de passe" required>

  <button type="submit">Créer un compte</button>

</form>

    <p class="alt-link">
      Déjà inscrit ?
      <a href="login.php">Se connecter</a>
    </p>
  </div>
</main>

<?php require 'templates/footer.php'; ?>
