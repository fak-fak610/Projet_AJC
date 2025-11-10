<?php
require_once('Database.php');

class Livres {
    public static function getAll() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM livres ORDER BY date_ajout DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($titre, $auteur, $image, $description = '') {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, image, description, date_ajout) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$titre, $auteur, $image, $description]);
    }

    public static function update($id, $titre, $auteur, $image, $description = '') {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE livres SET titre = ?, auteur = ?, image = ?, description = ? WHERE id = ?");
        return $stmt->execute([$titre, $auteur, $image, $description, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
