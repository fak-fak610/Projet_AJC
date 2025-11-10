<?php
// On commente tout le code PHP pour l'instant
// require_once '../model/Formation.php';

class FormationController {
    public function index() {
        // TEMPORAIRE : on charge juste la vue HTML sans données
        // $formations = Formation::getAll();
        
        // On charge juste la page HTML
        require_once '../view/formation_view.php';
    }
}
?>