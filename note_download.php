<?php
require 'inc/auth.php';
require 'config/database.php';

if (!isLoggedIn()) exit;

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM user_notes
    WHERE id = :id AND user_id = :uid
");
$stmt->execute([
    'id'  => $id,
    'uid' => $_SESSION['user_id']
]);

$note = $stmt->fetch();

if (!$note) die("Note introuvable");

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"note_{$note['id']}.txt\"");

echo "Titre : {$note['title']}\n";
echo "Matière : {$note['matiere']}\n\n";
echo $note['content'];
exit;
