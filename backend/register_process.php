<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../config/database.php';

// Sécurité : uniquement POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../register.php");
    exit;
}

// Récupération des données
$nom     = trim($_POST['nom'] ?? '');
$prenom  = trim($_POST['prenom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Vérification champs
if ($nom === '' || $prenom === '' || $email === '' || $password === '') {
    die("Tous les champs sont obligatoires.");
}

// Vérifier si email existe déjà
$sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);

if ($stmt->fetch()) {
    die("Cet email est déjà utilisé.");
}

// Hash du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertion utilisateur
$sql = "INSERT INTO users (nom, prenom, email, password)
        VALUES (:nom, :prenom, :email, :password)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'password' => $hashedPassword
]);

// Redirection vers connexion
header("Location: ../login.php");
exit;
