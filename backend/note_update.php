<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn()) exit;

$stmt = $pdo->prepare("
    UPDATE user_notes
    SET title = :title, matiere = :matiere, content = :content
    WHERE id = :id AND user_id = :uid
");

$stmt->execute([
    'title'   => $_POST['title'],
    'matiere' => $_POST['matiere'],
    'content' => $_POST['content'],
    'id'      => $_POST['id'],
    'uid'     => $_SESSION['user_id']
]);

header("Location: ../notes.php");
exit;
