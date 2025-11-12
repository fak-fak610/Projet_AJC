<?php
require_once '../model/User.php';

class InscriptionController {
    public function index() {
        include '../view/inscription.php';
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $errors = [];

        // Validation des champs requis
        if (!$username) {
            $errors[] = "Le nom d'utilisateur est requis.";
        }
        if (!$email) {
            $errors[] = "L'adresse e-mail est requise.";
        }
        if (!$password) {
            $errors[] = "Le mot de passe est requis.";
        }
        if (!$confirm_password) {
            $errors[] = "La confirmation du mot de passe est requise.";
        }

        // Validation du mot de passe
        if ($password) {
            if (strlen($password) < 8) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
            }
            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
            }
            if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
                $errors[] = "Le mot de passe doit contenir au moins un symbole (ex: !@#$%^&*).";
            }
        }

        // Vérifier si les mots de passe correspondent
        if ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        // Vérifier si l'utilisateur ou l'email existe déjà
        if ($username && User::getByUsername($username)) {
            $errors[] = "Ce nom d'utilisateur est déjà pris.";
        }
        if ($email && User::getByEmail($email)) {
            $errors[] = "Cette adresse e-mail est déjà utilisée.";
        }

        if (empty($errors)) {
            User::create($username, $email, $password);
            $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            include '../view/inscription.php';
        } else {
            include '../view/inscription.php';
        }
    }
}
?>
