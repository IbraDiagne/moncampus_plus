<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn()) exit;

$stmt = $pdo->prepare("
    INSERT INTO user_notes
    (user_id, filiere, semestre, matiere, title, content)
    VALUES
    (:uid, :filiere, :semestre, :matiere, :title, :content)
");

$stmt->execute([
    'uid'      => $_SESSION['user_id'],
    'filiere'  => $_SESSION['user_filiere'] ?? 'unknown',
    'semestre' => $_SESSION['last_semestre'] ?? 1,
    'matiere'  => $_POST['matiere'],
    'title'    => $_POST['title'],
    'content'  => $_POST['content']
]);

header("Location: ../notes.php");
exit;
