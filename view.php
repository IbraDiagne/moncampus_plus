<?php
require 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(404);
    exit('Fichier introuvable');
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT filename, mime_type
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

/* 🔒 HEADERS PDF PROPRES */
header('Content-Type: application/pdf');
header('Content-Length: ' . filesize($path));
header('Content-Disposition: inline; filename="' . basename($file['filename']) . '"');
header('Accept-Ranges: bytes');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

readfile($path);
exit;



