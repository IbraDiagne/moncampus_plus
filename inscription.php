<?php include 'partials/navbar.php'; ?>

<div class="container page">
  <h1>Créer un compte</h1>

  <form class="form-card">
    <input type="text" placeholder="Nom complet" required>
    <input type="email" placeholder="Email" required>
    <input type="password" placeholder="Mot de passe" required>

    <button type="submit">S'inscrire</button>
  </form>

  <p class="alt-link">
    Déjà inscrit ?
    <a href="login.php">Se connecter</a>
  </p>
</div>
