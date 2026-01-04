<?php
/**
 * Protection d'accès administrateur
 * Ce fichier vérifie si l'utilisateur a les droits d'administrateur
 * À inclure en début de chaque page réservée aux admins
 */

// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion
    header('Location: index.php?page=connexion');
    exit();
}

// Vérifier si l'utilisateur a le rôle administrateur
// Supposons que le rôle soit stocké dans $_SESSION['user_role']
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Rediriger vers une page d'erreur ou la page d'accueil
    header('Location: index.php?page=home&error=access_denied');
    exit();
}

// Si on arrive ici, l'utilisateur est un admin authentifié
// Le script continue normalement
?>
