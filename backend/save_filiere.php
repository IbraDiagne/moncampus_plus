<?php
session_start();
require __DIR__ . '/../config/database.php';

// Sécurité
if (!isset($_SESSION['user_id']) || !isset($_POST['filiere'])) {
    header("Location: ../dashboard.php");
    exit;
}

$userId  = $_SESSION['user_id'];
$filiere = $_POST['filiere'];

// Vérifier si le profil existe déjà
$stmt = $pdo->prepare("SELECT id FROM user_profile WHERE user_id = :id");
$stmt->execute(['id' => $userId]);
$exists = $stmt->fetch();

if ($exists) {
    // 🔄 Mise à jour
    $stmt = $pdo->prepare("
        UPDATE user_profile 
        SET filiere = :filiere 
        WHERE user_id = :user_id
    ");
} else {
    // ➕ Insertion
    $stmt = $pdo->prepare("
        INSERT INTO user_profile (user_id, filiere)
        VALUES (:user_id, :filiere)
    ");
}

$stmt->execute([
    'user_id' => $userId,
    'filiere' => $filiere
]);

header("Location: ../dashboard.php");
exit;
