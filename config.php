<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ajc_mooc_biblio_formation;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Connexion réussie à la base ajc_mooc_biblio_formation";
} catch (PDOException $e) {
    die("❌ Connexion échouée : " . $e->getMessage());
}
?>
