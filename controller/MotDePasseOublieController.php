<?php
require_once 'model/User.php';

class MotDePasseOublieController {
    public function index() {
        include 'view/mot_de_passe_oublie.php';
    }

    public function reset() {
        $email = $_POST['email'] ?? '';

        if ($email) {
            // Logique pour réinitialiser le mot de passe (envoyer un email, etc.)
            // Pour l'exemple, on simule
            echo "Un email de réinitialisation a été envoyé à $email.";
        } else {
            echo "Erreur : email requis.";
        }
    }
}
?>
