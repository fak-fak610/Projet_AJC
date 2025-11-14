<?php
require_once __DIR__ . '/../config.php';

class Livres {

    public static function getAll() {
        $pdo = Database::getConnection();

        // On sélectionne uniquement les colonnes existantes
        $sql = "SELECT id, titre, image, description, date_ajout FROM livres";
        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}