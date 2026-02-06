<?php
session_start();
require __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$rating = (int) ($_POST['rating'] ?? 0);

if ($rating < 1 || $rating > 5) {
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->prepare("
  INSERT INTO ratings (user_id, rating)
  VALUES (:user_id, :rating)
  ON DUPLICATE KEY UPDATE rating = :rating
");

$stmt->execute([
  'user_id' => $_SESSION['user_id'],
  'rating' => $rating
]);

header("Location: ../index.php");
exit;
