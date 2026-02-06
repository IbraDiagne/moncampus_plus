<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO todo_tasks
    (user_id, filiere, semestre, matiere, type, title, priority, due_date)
    VALUES
    (:uid, :filiere, :semestre, :matiere, :type, :title, :priority, :due)
");

$stmt->execute([
    'uid'      => $_SESSION['user_id'],
    'filiere'  => $_SESSION['user_filiere'] ?? 'unknown',
    'semestre' => $_SESSION['last_semestre'] ?? 1,
    'matiere'  => $_POST['matiere'],
    'type'     => $_POST['type'],
    'title'    => $_POST['title'],
    'priority' => $_POST['priority'],
    'due'      => $_POST['due_date'] ?: null
]);

header("Location: ../todo.php");
exit;
