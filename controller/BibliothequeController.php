<?php
require_once('../model/Livres.php');
class BibliothequeController {
    public function index() {
        $livres = Livres::getAll();
        include('../view/bibliotheque_view.php');
    }
}
?>
