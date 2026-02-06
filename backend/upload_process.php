<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../upload.php");
    exit;
}

/* ==========================
   RÉCUPÉRATION DES DONNÉES
========================== */
$user_id  = $_SESSION['user_id'];

$filiere  = $_POST['filiere']  ?? '';
$semestre = $_POST['semestre'] ?? '';
$matiere  = $_POST['matiere']  ?? '';
$type     = $_POST['type']     ?? '';
$khints_type = ($_POST['khints_type'] ?? null);

/* ==========================
   VALIDATION
========================== */
if (!$filiere || !$semestre || !$matiere || !$type) {
    $_SESSION['upload_error'] = "Tous les champs sont obligatoires.";
    header("Location: ../upload.php");
    exit;
}

if ($type !== 'khints') {
    $khints_type = null; // IMPORTANT
}

/* ==========================
   FICHIER
========================== */
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['upload_error'] = "Erreur lors de l’upload du fichier.";
    header("Location: ../upload.php");
    exit;
}

$allowedExt = ['pdf','jpg','jpeg','png'];
$originalName = $_FILES['file']['name'];
$tmpPath = $_FILES['file']['tmp_name'];
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($ext, $allowedExt)) {
    $_SESSION['upload_error'] = "Type de fichier non autorisé.";
    header("Location: ../upload.php");
    exit;
}

/* ==========================
   MÉTADONNÉES
========================== */
$mimeType = mime_content_type($tmpPath);
$fileSize = filesize($tmpPath);
$fileHash = hash_file('sha256', $tmpPath);

/* ==========================
   STOCKAGE LOCAL
========================== */
$newName = uniqid('file_', true) . '.' . $ext;
$uploadDir = __DIR__ . '/../uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

if (!move_uploaded_file($tmpPath, $uploadDir . $newName)) {
    $_SESSION['upload_error'] = "Impossible d’enregistrer le fichier.";
    header("Location: ../upload.php");
    exit;
}

/* ==========================
   INSERTION BDD
========================== */
$sql = "
INSERT INTO files
(user_id, filiere, semestre, matiere, type, khints_type,
 filename, original_name, mime_type, file_size, file_hash, status)
VALUES
(:user_id, :filiere, :semestre, :matiere, :type, :khints_type,
 :filename, :original_name, :mime_type, :file_size, :file_hash, 'active')
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'user_id'       => $user_id,
    'filiere'       => $filiere,
    'semestre'      => $semestre,
    'matiere'       => $matiere,
    'type'          => $type,
    'khints_type'   => $khints_type,
    'filename'      => $newName,
    'original_name' => $originalName,
    'mime_type'     => $mimeType,
    'file_size'     => $fileSize,
    'file_hash'     => $fileHash
]);

$_SESSION['upload_success'] = "✅ Fichier ajouté avec succès.";
header("Location: ../upload.php");
exit;
