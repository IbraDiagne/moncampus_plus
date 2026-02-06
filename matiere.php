<?php
// ================================
// SÉCURITÉ : paramètres obligatoires
// ================================
if (
    !isset($_GET['filiere']) ||
    !isset($_GET['semestre']) ||
    !isset($_GET['matiere'])
) {
    header("Location: index.php");
    exit;
}

$filiere  = $_GET['filiere'];
$semestre = $_GET['semestre'];
$matiere  = $_GET['matiere'];

// ================================
// LIENS GITHUB PAR MATIÈRE
// ================================
$githubLinks = [
    "Langage C" => "https://github.com/TonCompteGithub/langage-c",
    "Programmation orientée objet" => "https://github.com/TonCompteGithub/poo-java",
    "Backend" => "https://github.com/TonCompteGithub/backend",
    "Frontend" => "https://github.com/TonCompteGithub/frontend",
    "Administration Réseau" => "https://github.com/TonCompteGithub/admin-reseau"
];

include 'templates/header.php';
?>

<div class="container page">

    <!-- ===== TITRE ===== -->
    <div class="welcome">
        <h1 class="page-title"><?= htmlspecialchars($matiere) ?></h1>
        <p class="page-subtitle">Semestre <?= htmlspecialchars($semestre) ?></p>
    </div>

    <!-- ===== CHOIX DU CONTENU ===== -->
    <div class="cards">

        <a class="card"
           href="cours.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>&matiere=<?= urlencode($matiere) ?>">
            📘 Cours
        </a>

        <a class="card"
           href="tdtp.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>&matiere=<?= urlencode($matiere) ?>">
            📝 TD / TP
        </a>

        <a class="card"
           href="khints.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>&matiere=<?= urlencode($matiere) ?>">
            💡 Khints
        </a>

        <a class="card"
           href="ressources.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>&matiere=<?= urlencode($matiere) ?>">
            🌐 Ressources complémentaires
        </a>

        <?php if (isset($githubLinks[$matiere])): ?>
            <a
                class="card btn-github"
                href="<?= htmlspecialchars($githubLinks[$matiere]) ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                🔗 GitHub
            </a>
        <?php endif; ?>

    </div>

    <!-- ===== RETOUR ===== -->
    <div class="back-link">
        <a href="matieres.php?filiere=<?= urlencode($filiere) ?>&semestre=<?= urlencode($semestre) ?>">
            ← Retour à la liste des matières
        </a>
    </div>

</div>

<?php include 'templates/footer.php'; ?>
