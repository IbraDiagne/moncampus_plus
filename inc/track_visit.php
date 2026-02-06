<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

try {
    $page = $_SERVER['REQUEST_URI'] ?? '';
    $userId = $_SESSION['user_id'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    $stmt = $pdo->prepare("
        INSERT INTO visits (user_id, page, ip_address, visited_at)
        VALUES (:user_id, :page, :ip, NOW())
    ");

    $stmt->execute([
        'user_id' => $userId,
        'page'    => $page,
        'ip'      => $ip
    ]);
} catch (Throwable $e) {
    // NE RIEN AFFICHER (évite erreur 500)
}
