<?php
require 'config/database.php';
require 'templates/header.php';

$filiere=$_GET['filiere']??'';
$semestre=$_GET['semestre']??'';
$matiere=$_GET['matiere']??'';
$search=trim($_GET['search']??'');

$sql="SELECT * FROM files WHERE filiere=:f AND semestre=:s AND matiere=:m AND type='tdtp' AND status='active'";
$params=['f'=>$filiere,'s'=>$semestre,'m'=>$matiere];

if($search!==''){
  $sql.=" AND original_name LIKE :search";
  $params['search']="%$search%";
}

$stmt=$pdo->prepare($sql);
$stmt->execute($params);
$files=$stmt->fetchAll();
?>

<h1 class="page-title">📝 TD / TP</h1>

<form method="GET" class="search-box">
  <input type="hidden" name="filiere" value="<?= htmlspecialchars($filiere) ?>">
  <input type="hidden" name="semestre" value="<?= htmlspecialchars($semestre) ?>">
  <input type="hidden" name="matiere" value="<?= htmlspecialchars($matiere) ?>">
  <input type="text" name="search" placeholder="Rechercher TD/TP..." value="<?= htmlspecialchars($search) ?>">
  <button>Rechercher</button>
</form>

<div class="files-grid">
<?php foreach($files as $f): ?>
<div class="file-card">
  <div class="file-title"><?= htmlspecialchars($f['original_name']) ?></div>

  <div class="file-preview">
    <embed src="uploads/<?= $f['filename'] ?>" type="application/pdf">
  </div>

  <div class="file-actions">
    <a class="btn-download" href="uploads/<?= $f['filename'] ?>" download>Télécharger</a>

    <?php if(isset($_SESSION['user_id']) &&
      ($_SESSION['user_role']==='admin' || $_SESSION['user_id']==$f['user_id'])): ?>
    <form method="POST" action="backend/delete_file.php"
          onsubmit="return confirm('Supprimer ce fichier ?');">
      <input type="hidden" name="id" value="<?= $f['id'] ?>">
      <button class="btn-delete">Supprimer</button>
    </form>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
</div>

<?php include 'templates/footer.php'; ?>
