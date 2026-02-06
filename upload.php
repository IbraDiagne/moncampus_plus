<?php
require 'inc/auth.php';
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
require 'templates/header.php';

$matieres = [
    "l1_glsi" => [
        1 => ["Algèbre","Algorithme","Architecture des ordinateurs","Économie","Initiation","Maths discrètes","Raisonnement","Réseaux","Systèmes d’exploitation"],
        2 => ["Algorithme et structures de données","Analyse","Économie de l’entreprise","Frontend","Langage C","Probabilités","Systèmes d’exploitation","SGBD","Techniques de communication","Technologies des ordinateurs"]
    ],
    "l2_glsi" => [
        1 => ["Administration Réseau","Anglais des affaires","Backend","Entreprenariat","Gestion de projet","Modélisation SI","POO","Recherche opérationnelle","Systèmes d’exploitation"],
        2 => ["Développement mobile","Bases de données avancées","IHM","IA","Veille technologique"]
    ]
];
?>

<div class="container page upload-wrapper">

<?php if (!empty($_SESSION['upload_error'])): ?>
<div class="alert alert-danger"><?= htmlspecialchars($_SESSION['upload_error']) ?></div>
<?php unset($_SESSION['upload_error']); endif; ?>

<?php if (!empty($_SESSION['upload_success'])): ?>
<div class="alert alert-success"><?= htmlspecialchars($_SESSION['upload_success']) ?></div>
<?php unset($_SESSION['upload_success']); endif; ?>

<h1 class="page-title">📤 Ajouter un fichier</h1>

<form action="backend/upload_process.php" method="POST" enctype="multipart/form-data" class="auth-box">

<h3>🎓 Contexte académique</h3>

<select name="filiere" id="filiere" required>
<option value="">Filière</option>
<option value="l1_glsi">L1 GLSI</option>
<option value="l2_glsi">L2 GLSI</option>
</select>

<select name="semestre" id="semestre" required disabled>
<option value="">Semestre</option>
<option value="1">Semestre 1</option>
<option value="2">Semestre 2</option>
</select>

<select name="matiere" id="matiere" required disabled>
<option value="">Matière</option>
</select>

<h3>📂 Type</h3>
<select name="type" id="type" required>
<option value="">Type</option>
<option value="cours">Cours</option>
<option value="tdtp">TD / TP</option>
<option value="khints">Khints</option>
<option value="ressources">Ressources</option>
</select>

<select name="khints_type" id="khints_type" style="display:none;">
<option value="">Type Khints</option>
<option value="cc">CC</option>
<option value="ds">DS</option>
</select>

<h3>📎 Fichier</h3>
<input type="file" name="file" id="file" required accept=".pdf,.jpg,.jpeg,.png">

<div id="preview" style="margin-top:15px;"></div>

<button type="submit">Uploader</button>
</form>
</div>

<script>
const matieres = <?= json_encode($matieres) ?>;
const filiere = document.getElementById('filiere');
const semestre = document.getElementById('semestre');
const matiere = document.getElementById('matiere');
const type = document.getElementById('type');
const khintsBox = document.getElementById('khints_type');
const fileInput = document.getElementById('file');
const preview = document.getElementById('preview');

filiere.onchange = () => {
  semestre.disabled = !filiere.value;
};

semestre.onchange = () => {
  matiere.innerHTML = '<option value="">Matière</option>';
  matiere.disabled = false;
  matieres[filiere.value][semestre.value].forEach(m => {
    const o = document.createElement('option');
    o.value = m; o.textContent = m;
    matiere.appendChild(o);
  });
};

type.onchange = () => {
  khintsBox.style.display = (type.value === 'khints') ? 'block' : 'none';
};

fileInput.onchange = () => {
  preview.innerHTML = '';
  const f = fileInput.files[0];
  if (!f) return;

  if (f.type === 'application/pdf') {
    const e = document.createElement('embed');
    e.src = URL.createObjectURL(f);
    e.width = "100%";
    e.height = "300";
    preview.appendChild(e);
  } else if (f.type.startsWith('image/')) {
    const img = document.createElement('img');
    img.src = URL.createObjectURL(f);
    img.style.maxWidth = "300px";
    preview.appendChild(img);
  }
};
</script>

<?php include 'templates/footer.php'; ?>
