<?php
require_once '../model/Livres.php';

class LivresController {
    public function index() {
        // Récupérer tous les livres
        $livres = Livres::getAll();

        // Charger la vue des livres
        require_once '../view/livres_view.php';
    }
}
?>
