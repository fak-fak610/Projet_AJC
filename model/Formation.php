<?php
require_once('Database.php');

class Formation {
    public static function getAll() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM formations ORDER BY date_creation DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM formations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($titre, $description, $image, $duree = '', $niveau = '') {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO formations (titre, description, image, duree, niveau, date_creation) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$titre, $description, $image, $duree, $niveau]);
    }

    public static function update($id, $titre, $description, $image, $duree = '', $niveau = '') {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE formations SET titre = ?, description = ?, image = ?, duree = ?, niveau = ? WHERE id = ?");
        return $stmt->execute([$titre, $description, $image, $duree, $niveau, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM formations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
