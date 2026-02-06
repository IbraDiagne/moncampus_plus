<?php
// ================================
// DEBUG (à enlever plus tard)
// ================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================
// SESSION
// ================================
session_start();

// ================================
// CONNEXION BDD
// ================================
require __DIR__ . '/../config/database.php';

// ================================
// SÉCURITÉ MÉTHODE
// ================================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

// ================================
// DONNÉES FORMULAIRE
// ================================
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    die("Tous les champs sont obligatoires.");
}

// ================================
// RÉCUPÉRATION UTILISATEUR
// ================================
$sql = "SELECT id, nom, prenom, email, password 
        FROM users 
        WHERE email = :email 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Email ou mot de passe incorrect.");
}

// ================================
// VÉRIFICATION MOT DE PASSE
// ================================
if (!password_verify($password, $user['password'])) {
    die("Email ou mot de passe incorrect.");
}

// ================================
// CONNEXION RÉUSSIE
// ================================
$_SESSION['user_id']     = $user['id'];
$_SESSION['user_nom']    = $user['nom'];
$_SESSION['user_prenom'] = $user['prenom'];
$_SESSION['user_email']  = $user['email'];
$_SESSION['user_role']   = $user['role'];
// ================================
// REDIRECTION
// ================================
header("Location: ../index.php");
exit;
