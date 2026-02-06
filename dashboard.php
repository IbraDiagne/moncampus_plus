<?php
session_start();
require 'config/database.php';

// ================================
// SÉCURITÉ : utilisateur connecté
// ================================
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ================================
// RÉCUPÉRATION DU PROFIL
// ================================
$stmt = $pdo->prepare("
    SELECT filiere, last_semestre
    FROM user_profile
    WHERE user_id = :user_id
    LIMIT 1
");
$stmt->execute([
    'user_id' => $_SESSION['user_id']
]);

$profile = $stmt->fetch();

if (
    !$profile ||
    empty($profile['filiere']) ||
    empty($profile['last_semestre'])
) {
    // Profil incomplet → forcer le choix
    header("Location: index.php");
    exit;
}

$filiere  = $profile['filiere'];
$semestre = $profile['last_semestre'];

include 'templates/header.php';
?>

<div class="container page">

    <h1 class="page-title">
        Bienvenue <?= htmlspecialchars($_SESSION['user_prenom']) ?>
    </h1>

    <p class="page-subtitle">
        Reprendre vos cours là où vous vous êtes arrêté
    </p>

    <div class="cards">

        <a class="card"
           href="matieres.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>">
            ▶️ Continuer mes cours
        </a>

        <a class="card" href="index.php">
            🔁 Changer de filière
        </a>
	<a class="card" href="todo.php">📝 Mon planning de révision</a>

	<a class="card" href="notes.php">📝 Mes notes personnelles</a>
    </div>

</div>

<?php include 'templates/footer.php'; ?>
