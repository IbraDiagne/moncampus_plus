<?php
session_start();
require __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Accès refusé");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode invalide");
}

$id = (int) ($_POST['id'] ?? 0);

// Récupérer le fichier
$stmt = $pdo->prepare("SELECT * FROM files WHERE id = ?");
$stmt->execute([$id]);
$file = $stmt->fetch();

if (!$file) {
    die("Fichier introuvable");
}

// Autorisation : admin OU propriétaire
if (
    $_SESSION['user_role'] !== 'admin' &&
    $_SESSION['user_id'] != $file['user_id']
) {
    die("Accès interdit");
}

// Supprimer le fichier physique
$filePath = __DIR__ . '/../uploads/' . $file['filename'];
if (file_exists($filePath)) {
    unlink($filePath);
}

// Supprimer en base
$pdo->prepare("DELETE FROM files WHERE id = ?")->execute([$id]);

// Retour à la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
