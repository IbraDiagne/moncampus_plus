<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn()) exit;

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    DELETE FROM user_notes
    WHERE id = :id AND user_id = :uid
");

$stmt->execute([
    'id'  => $id,
    'uid' => $_SESSION['user_id']
]);

header("Location: ../notes.php");
exit;
