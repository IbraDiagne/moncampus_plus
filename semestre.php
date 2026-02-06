<?php
session_start();
require 'config/database.php';

// ================================
// SÉCURITÉ : filière obligatoire
// ================================
if (!isset($_GET['filiere']) || empty($_GET['filiere'])) {
    header("Location: index.php");
    exit;
}

$filiere = $_GET['filiere'];

// Libellés lisibles
$filiereLabels = [
    "l1_glsi"   => "L1 Génie Logiciel & Systèmes d’Information",
    "l2_glsi"   => "L2 Génie Logiciel & Systèmes d’Information",
    "l3_glsi"   => "L3 Génie Logiciel & Systèmes d’Information",
    "dut1_info" => "DUT 1 Informatique",
    "dut2_info" => "DUT 2 Informatique"
];

// Sécurité : filière inconnue
if (!isset($filiereLabels[$filiere])) {
    header("Location: index.php");
    exit;
}

// ================================
// SAUVEGARDE FILIÈRE (si connecté)
// ================================
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("
        UPDATE user_profile
        SET filiere = :filiere
        WHERE user_id = :user_id
    ");
    $stmt->execute([
        'filiere' => $filiere,
        'user_id' => $_SESSION['user_id']
    ]);
}

include 'templates/header.php';
?>

<div class="container page">

    <div class="welcome">
        <h1 class="page-title">Choix du semestre</h1>
        <p class="page-subtitle"><?= htmlspecialchars($filiereLabels[$filiere]) ?></p>
    </div>

    <div class="cards">
        <a class="card"
           href="matieres.php?filiere=<?= urlencode($filiere) ?>&semestre=1&save=1">
            📘 Semestre 1
        </a>

        <a class="card"
           href="matieres.php?filiere=<?= urlencode($filiere) ?>&semestre=2&save=1">
            📗 Semestre 2
        </a>
    </div>

    <div class="back-link">
        <a href="index.php">← Retour aux filières</a>
    </div>

</div>

<?php include 'templates/footer.php'; ?>
