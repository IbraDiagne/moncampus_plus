<?php
// ================================
// SÉCURITÉ : paramètres obligatoires
// ================================
if (
    empty($_GET['filiere']) ||
    empty($_GET['semestre']) ||
    empty($_GET['matiere'])
) {
    header("Location: index.php");
    exit;
}

$filiere  = $_GET['filiere'];
$semestre = $_GET['semestre'];
$matiere  = $_GET['matiere'];

include 'templates/header.php';
?>

<div class="container page">

  <!-- TITRE -->
  <h1 class="page-title">💻 Projets GitHub</h1>
  <p class="page-subtitle"><?= htmlspecialchars($matiere) ?></p>

  <!-- CONTENU -->
  <div class="cards">
    <div class="card">
      Aucun projet GitHub disponible pour le moment.
    </div>
  </div>

  <!-- RETOUR CORRECT -->
  <div class="back-link">
    <a href="matiere.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>&matiere=<?= urlencode($matiere) ?>">
      ← Retour à la matière
    </a>
  </div>

</div>

<?php include 'templates/footer.php'; ?>
