<?php
require_once('model/Database.php');

try {
    $pdo = Database::getConnection();

    // Supprimer l'ancien admin s'il existe
    $pdo->query("DELETE FROM utilisateurs WHERE username = 'admin' OR email = 'admin@ajc.fr'");

    // Créer un nouvel admin avec mot de passe simple
    $password = 'admin123';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['admin', 'admin@ajc.fr', $hashedPassword, 'admin']);

    echo "✅ Compte admin créé avec succès !<br>";
    echo "Username: admin<br>";
    echo "Email: admin@ajc.fr<br>";
    echo "Mot de passe: admin123<br><br>";
    echo "Vous pouvez maintenant vous connecter à la page admin.";

    // Vérifier que l'utilisateur a été créé
    $stmt = $pdo->prepare("SELECT id, username, email, role FROM utilisateurs WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<br>✅ Vérification : Utilisateur créé avec ID " . $user['id'] . " et role '" . $user['role'] . "'";
    } else {
        echo "<br>❌ Erreur : L'utilisateur n'a pas été trouvé après création";
    }

    // Afficher tous les utilisateurs admin
    echo "<br><br>📋 Liste des utilisateurs admin :";
    $stmt = $pdo->query("SELECT id, username, email, role FROM utilisateurs WHERE role = 'admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($admins) > 0) {
        echo "<ul>";
        foreach ($admins as $admin) {
            echo "<li>ID: {$admin['id']}, Username: {$admin['username']}, Email: {$admin['email']}, Role: {$admin['role']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<br>Aucun utilisateur admin trouvé.";
    }

    // Tester la connexion admin
    echo "<br><br>🧪 Test de connexion admin :";
    $testLogin = 'admin';
    $testPassword = 'admin123';

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE (username = ? OR email = ?) AND role = 'admin'");
    $stmt->execute([$testLogin, $testLogin]);
    $adminUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($adminUser && password_verify($testPassword, $adminUser['password'])) {
        echo "<br>✅ Test réussi : Connexion admin valide";
    } else {
        echo "<br>❌ Test échoué : Problème avec la connexion admin";
        if (!$adminUser) {
            echo "<br>- Utilisateur admin non trouvé";
        } else {
            echo "<br>- Mot de passe incorrect";
        }
    }

} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
