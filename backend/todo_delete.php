<?php
require '../inc/auth.php';
require '../config/database.php';

if (!isLoggedIn()) {
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    DELETE FROM todo_tasks
    WHERE id = :id AND user_id = :uid
");

$stmt->execute([
    'id'  => $id,
    'uid' => $_SESSION['user_id']
]);

header("Location: ../todo.php");
exit;
