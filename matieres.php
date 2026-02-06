<?php
session_start();
require 'config/database.php';

// ================================
// PARAMÈTRES OBLIGATOIRES
// ================================
$filiere  = $_GET['filiere']  ?? '';
$semestre = $_GET['semestre'] ?? '';

if ($filiere === '' || $semestre === '') {
    header("Location: index.php");
    exit;
}

// ================================
// SAUVEGARDE DU DERNIER SEMESTRE
// ================================
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("
        UPDATE user_profile
        SET last_semestre = :semestre
        WHERE user_id = :user_id
    ");
    $stmt->execute([
        'semestre' => (int)$semestre,
        'user_id'  => $_SESSION['user_id']
    ]);
}

include 'templates/header.php';

// ==========================
// MATIÈRES OFFICIELLES
// ==========================
$matieres = [

  "l1_glsi" => [
    1 => [
      "Algèbre",
      "Algorithme",
      "Architecture des ordinateurs",
      "Économie",
      "Initiation",
      "Maths discrètes",
      "Raisonnement",
      "Réseaux",
      "Systèmes d’exploitation"
    ],
    2 => [
      "Algorithme et structures de données",
      "Analyse",
      "Économie de l’entreprise",
      "Frontend",
      "Langage C",
      "Probabilités",
      "Systèmes d’exploitation",
      "SGBD",
      "Techniques de communication",
      "Technologies des ordinateurs"
    ]
  ],

  "dut1_info" => [
    1 => [
      "Algèbre",
      "Algorithme",
      "Architecture des ordinateurs",
      "Économie",
      "Initiation",
      "Maths discrètes",
      "Raisonnement",
      "Réseaux",
      "Systèmes d’exploitation"
    ],
    2 => [
      "Algorithme et structures de données",
      "Analyse",
      "Économie de l’entreprise",
      "Frontend",
      "Langage C",
      "Probabilités",
      "Systèmes d’exploitation",
      "SGBD",
      "Techniques de communication",
      "Technologies des ordinateurs"
    ]
  ],

  "l2_glsi" => [
    1 => [
      "Administration Réseau",
      "Anglais des affaires",
      "Backend",
      "Entreprenariat et innovation",
      "Gestion de l’entreprise",
      "Gestion de projet",
      "Modélisation des systèmes d’information",
      "Programmation orientée objet",
      "Recherche opérationnelle",
      "Systèmes d’exploitation"
    ],
    2 => [
      "Introduction au développement mobile",
      "Étude de cas en MSI",
      "Approfondissement en bases de données",
      "Préparation à l’insertion professionnelle",
      "Veille technologique",
      "Programmation par composants",
      "Intégration de modèles IA",
      "Initiation à l’IHM",
      "Conduite de projet"
    ]
  ],

  "dut2_info" => [
    1 => [
      "Administration Réseau",
      "Anglais des affaires",
      "Backend",
      "Entreprenariat et innovation",
      "Gestion de l’entreprise",
      "Gestion de projet",
      "Modélisation des systèmes d’information",
      "Programmation orientée objet",
      "Recherche opérationnelle",
      "Systèmes d’exploitation"
    ],
    2 => [
      "Introduction au développement mobile",
      "Étude de cas en MSI",
      "Approfondissement en bases de données",
      "Préparation à l’insertion professionnelle",
      "Veille technologique",
      "Programmation par composants",
      "Intégration de modèles IA",
      "Initiation à l’IHM",
      "Conduite de projet"
    ]
  ]
];
?>

<div class="container page">

  <h1 class="page-title">Liste des matières</h1>
  <p class="page-subtitle">Semestre <?= htmlspecialchars($semestre) ?></p>

  <div class="cards">
    <?php
    if (isset($matieres[$filiere][$semestre])) {
        foreach ($matieres[$filiere][$semestre] as $m) {
            echo '<a class="card" href="matiere.php?filiere='
                . urlencode($filiere)
                . '&semestre='
                . urlencode($semestre)
                . '&matiere='
                . urlencode($m)
                . '">' . htmlspecialchars($m) . '</a>';
        }
    } else {
        echo "<p>Aucune matière disponible.</p>";
    }
    ?>
  </div>

  <div class="back-link">
    <a href="semestre.php?filiere=<?= urlencode($filiere) ?>">
      ← Retour aux semestres
    </a>
  </div>

</div>

<?php include 'templates/footer.php'; ?>
