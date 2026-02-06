<?php
require 'config/database.php';

/* =========================
   VALIDATION ID
========================= */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(404);
    exit('Fichier introuvable');
}

$id = (int) $_GET['id'];

/* =========================
   RÉCUPÉRATION DU FICHIER
========================= */
$stmt = $pdo->prepare("
    SELECT filename, original_name, mime_type
    FROM files
    WHERE id = :id AND status = 'active'
");
$stmt->execute(['id' => $id]);
$file = $stmt->fetch();

if (!$file) {
    http_response_code(404);
    exit('Fichier introuvable');
}

$path = __DIR__ . '/uploads/' . $file['filename'];

if (!file_exists($path)) {
    http_response_code(404);
    exit('Fichier manquant');
}

/* =========================
   INCRÉMENT DES TÉLÉCHARGEMENTS
========================= */
$pdo->prepare("
    UPDATE files
    SET downloads = downloads + 1
    WHERE id = :id
")->execute(['id' => $id]);

/* =========================
   HEADERS DE SÉCURITÉ
========================= */
header('Content-Description: File Transfer');
header('Content-Type: ' . $file['mime_type']);
header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
header('Content-Length: ' . filesize($path));
header('Pragma: public');
header('Cache-Control: must-revalidate');
header('Expires: 0');

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: no-referrer');

/* =========================
   LECTURE DU FICHIER
========================= */
readfile($path);
exit;
