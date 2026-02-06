<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['visit_start'])) {
    return;
}

$duration = time() - $_SESSION['visit_start'];

require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("
        INSERT INTO visits (user_id, duration)
        VALUES (:user_id, :duration)
    ");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'duration' => $duration
    ]);
}

unset($_SESSION['visit_start']);
