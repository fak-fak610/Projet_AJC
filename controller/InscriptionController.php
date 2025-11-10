<?php
require_once 'model/User.php';

class InscriptionController {
    public function index() {
        include 'view/inscription.php';
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username && $email && $password) {
            User::create($username, $email, $password);
            header('Location: connexion.php');
            exit;
        } else {
            echo "Erreur : tous les champs sont requis.";
        }
    }
}
?>
