<?php
session_start();
require 'config/database.php';
require 'templates/header.php';

/* =========================
   PARAMÈTRES OBLIGATOIRES
========================= */
$filiere  = $_GET['filiere']  ?? '';
$semestre = $_GET['semestre'] ?? '';
$matiere  = $_GET['matiere']  ?? '';
$mode     = $_GET['mode']     ?? 'cc'; // cc | ds

if ($filiere === '' || $semestre === '' || $matiere === '') {
    header("Location: index.php");
    exit;
}

/* =========================
   OPTIONS
========================= */
$search = trim($_GET['search'] ?? '');
$sort   = $_GET['sort'] ?? 'recent';
$page   = max(1, (int)($_GET['page'] ?? 1));

$limit  = 10;
$offset = ($page - 1) * $limit;

/* =========================
   TRI
========================= */
$orderBy = ($sort === 'downloads')
    ? 'downloads DESC'
    : 'uploaded_at DESC';

/* =========================
   CONDITIONS SQL
========================= */
$where = "
    filiere = :filiere
    AND semestre = :semestre
    AND matiere = :matiere
    AND type = 'khints'
    AND khints_type = :mode
    AND status = 'active'
";

$params = [
    'filiere'  => $filiere,
    'semestre' => $semestre,
    'matiere'  => $matiere,
    'mode'     => $mode
];

if ($search !== '') {
    $where .= " AND original_name LIKE :search";
    $params['search'] = '%' . $search . '%';
}

/* =========================
   TOTAL (PAGINATION)
========================= */
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM files WHERE $where");
$countStmt->execute($params);
$totalFiles = (int) $countStmt->fetchColumn();
$totalPages = max(1, ceil($totalFiles / $limit));

/* =========================
   FICHIERS
========================= */
$sql = "
    SELECT *
    FROM files
    WHERE $where
    ORDER BY $orderBy
    LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($sql);

foreach ($params as $k => $v) {
    $stmt->bindValue(':' . $k, $v);
}

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$files = $stmt->fetchAll();
?>

<div class="container page">

<h1 class="page-title">💡 Khints</h1>
<p class="page-subtitle"><?= htmlspecialchars($matiere) ?> — <?= strtoupper($mode) ?></p>

<!-- ===== CC / DS ===== -->
<div class="nav-actions">
    <a class="btn-link <?= $mode === 'cc' ? 'active' : '' ?>"
       href="?<?= http_build_query(array_merge($_GET,['mode'=>'cc','page'=>1])) ?>">CC</a>

    <a class="btn-link <?= $mode === 'ds' ? 'active' : '' ?>"
       href="?<?= http_build_query(array_merge($_GET,['mode'=>'ds','page'=>1])) ?>">DS</a>
</div>

<!-- ===== RECHERCHE ===== -->
<form method="get" class="search-box">
    <input type="hidden" name="filiere" value="<?= htmlspecialchars($filiere) ?>">
    <input type="hidden" name="semestre" value="<?= htmlspecialchars($semestre) ?>">
    <input type="hidden" name="matiere" value="<?= htmlspecialchars($matiere) ?>">
    <input type="hidden" name="mode" value="<?= htmlspecialchars($mode) ?>">
    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">

    <input type="text" name="search" placeholder="🔍 Rechercher un khint..."
           value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Rechercher</button>
</form>

<!-- ===== TRI ===== -->
<div class="khints-sort">
    <a class="<?= $sort === 'recent' ? 'active' : '' ?>"
       href="?<?= http_build_query(array_merge($_GET,['sort'=>'recent','page'=>1])) ?>">
        🆕 Plus récents
    </a>

    <a class="<?= $sort === 'downloads' ? 'active' : '' ?>"
       href="?<?= http_build_query(array_merge($_GET,['sort'=>'downloads','page'=>1])) ?>">
        🔥 Plus téléchargés
    </a>
</div>

<!-- ===== LISTE ===== -->
<?php if (!$files): ?>
    <p style="text-align:center;opacity:.7">Aucun khint disponible.</p>
<?php else: ?>
<div class="files-grid">
<?php foreach ($files as $file): ?>
    <div class="file-card">

        <div class="file-title" title="<?= htmlspecialchars($file['original_name']) ?>">
            <?= htmlspecialchars($file['original_name']) ?>
        </div>

        <div class="file-preview">
            <embed src="uploads/<?= htmlspecialchars($file['filename']) ?>" type="application/pdf">
        </div>

        <div class="file-actions">
            <a class="btn-download" href="download.php?id=<?= $file['id'] ?>">
                Télécharger (<?= (int)$file['downloads'] ?>)
            </a>

            <?php if (
                isset($_SESSION['user_id']) &&
                ($_SESSION['user_role'] === 'admin' || $_SESSION['user_id'] == $file['user_id'])
            ): ?>
            <form method="post" action="backend/delete_file.php"
                  onsubmit="return confirm('Supprimer ce fichier ?');">
                <input type="hidden" name="id" value="<?= $file['id'] ?>">
                <button class="btn-delete">Supprimer</button>
            </form>
            <?php endif; ?>
        </div>

    </div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ===== PAGINATION ===== -->
<div class="pagination">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a class="<?= $i === $page ? 'active' : '' ?>"
       href="?<?= http_build_query(array_merge($_GET,['page'=>$i])) ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
</div>

</div>

<?php include 'templates/footer.php'; ?>
