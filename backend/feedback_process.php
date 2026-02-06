<?php
require __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

$name    = trim($_POST['name'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($message === '') {
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO feedbacks (name, message)
    VALUES (:name, :message)
");

$stmt->execute([
    'name'    => $name ?: 'Anonyme',
    'message' => $message
]);

header("Location: ../index.php");
exit;
