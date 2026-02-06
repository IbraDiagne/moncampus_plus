<?php
require 'inc/auth.php';

if (!isLoggedIn()) {
    header("Location: welcome.php");
    exit;
}

?>

<?php include 'templates/header.php'; ?>

<h1 class="page-title">Bienvenue sur MonCampus+</h1>
<p class="page-subtitle">Tout votre parcours academique, en un seul endroit</p>

<div class="cards">

  <a class="card" href="semestre.php?filiere=l1_glsi">
    L1 Génie Logiciel & SI
  </a>

  <a class="card" href="semestre.php?filiere=l2_glsi">
    L2 Génie Logiciel & SI
  </a>

  <a class="card" href="semestre.php?filiere=l3_glsi">
    L3 Génie Logiciel & SI
  </a>

  <a class="card" href="semestre.php?filiere=dut1_info">
    DUT 1 Informatique
  </a>

  <a class="card" href="semestre.php?filiere=dut2_info">
    DUT 2 Informatique
  </a>

</div>

<section class="feedback-section">
  <h2 class="section-title">💬 Votre avis compte</h2>
  <p class="section-subtitle">
    Dites-nous ce que vous pensez de MonCampus+
  </p>

  <form action="backend/feedback_process.php" method="POST" class="feedback-form">
    <input type="text" name="name" placeholder="Votre nom (optionnel)">
    <textarea name="message" placeholder="Votre message..." required></textarea>
    <button type="submit">Envoyer</button>
  </form>
</section>


<section class="about-section">
  <h2 class="section-title">📘 Comment fonctionne MonCampus+</h2>

  <p class="about-text">
    MonCampus+ est une plateforme pensée par et pour les étudiants.
    Elle centralise les cours, TD/TP, khints, ressources et projets
    afin de faciliter l’apprentissage universitaire.
  </p>

  <ul class="about-list">
    <li>✔ Choisir sa filière et son semestre</li>
    <li>✔ Accéder aux cours et supports</li>
    <li>✔ Lire les PDF directement sur le site</li>
    <li>✔ Contribuer à l’enrichissement des contenus</li>
  </ul>

  <div class="donation-box">
    <h3>🤝 Soutenir le projet</h3>
    <p>
      Si MonCampus+ vous aide, vous pouvez soutenir son développement.
    </p>

    <!-- Option simple -->
    <p class="don-note">
      📱 Orange Money / Wave : <strong>77 380 51 52</strong>
    </p>

    <!-- Option future -->
    <!--
    <a href="donation.php" class="don-btn">
      Faire un don
    </a>
    -->
  </div>
</section>


<section class="rating-section">
  <h2 class="section-title">⭐ Notez MonCampus+</h2>

  <form action="backend/rating_process.php" method="POST">
    <select name="rating" required>
      <option value="">Votre note</option>
      <option value="1">⭐</option>
      <option value="2">⭐⭐</option>
      <option value="3">⭐⭐⭐</option>
      <option value="4">⭐⭐⭐⭐</option>
      <option value="5">⭐⭐⭐⭐⭐</option>
    </select>
    <button type="submit">Envoyer</button>
  </form>
</section>

<?php include 'templates/footer.php'; ?>
