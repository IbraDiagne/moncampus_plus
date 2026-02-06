<?php require 'templates/header.php'; ?>

<main class="auth-page page">
  <div class="auth-box">
    <h2>Connexion</h2>

	<form action="/moncampus/backend/login_process.php" method="POST">

  		<input type="email" name="email" placeholder="Email" required>
  		<input type="password" name="password" placeholder="Mot de passe" required>

  		<button type="submit">Connexion</button>

	</form>


    <p class="alt-link">
      Pas encore de compte ?
      <a href="register.php">Créer un compte</a>
    </p>
  </div>
</main>

<?php require 'templates/footer.php'; ?>
