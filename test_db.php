<?php
// Connexion à MySQL
$conn = new mysqli("localhost", "root", "", "documents_biblio");

// Vérifie la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// On crée une table de test si elle n’existe pas
$conn->query("CREATE TABLE IF NOT EXISTS test_connexion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255)
)");

// On insère une valeur test
$conn->query("INSERT INTO test_connexion (message) VALUES ('HELLO_DB')");

// On lit la dernière valeur insérée
$result = $conn->query("SELECT message FROM test_connexion ORDER BY id DESC LIMIT 1");
$row = $result->fetch_assoc();

// Affiche le résultat sur ta page
echo "✅ Base de données connectée, dernier message = " . $row['message'];

$conn->close();
?>
