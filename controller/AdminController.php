<?php
require_once '../model/Database.php';

class AdminController {
    
    // Vérifier si l'utilisateur est admin
    private function checkAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin_login');
            exit;
        }
    }
    
    // ========== CONNEXION ADMIN ==========
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Si déjà connecté, rediriger vers dashboard
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin_dashboard');
            exit;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
                $stmt->execute([$username]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($admin && password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    header('Location: index.php?page=admin_dashboard');
                    exit;
                } else {
                    $error = "Identifiants incorrects";
                }
            } catch (PDOException $e) {
                $error = "Erreur de connexion : " . $e->getMessage();
            }
        }
        
        require_once '../view/admin/login.php';
    }
    
    // ========== DASHBOARD ==========
    public function dashboard() {
        $this->checkAdmin();
        
        try {
            $pdo = Database::getConnection();
            
            // Statistiques
            $stats = [
                'moocs' => $pdo->query("SELECT COUNT(*) FROM moocs")->fetchColumn(),
                'livres' => $pdo->query("SELECT COUNT(*) FROM livres")->fetchColumn(),
                'users' => $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn(),
                'documents' => $pdo->query("SELECT COUNT(*) FROM documents_user")->fetchColumn(),
            ];
            
            // Derniers ajouts
            $derniers_moocs = $pdo->query("SELECT titre, date FROM moocs ORDER BY date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            $derniers_users = $pdo->query("SELECT username, id FROM utilisateurs ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $stats = ['moocs' => 0, 'livres' => 0, 'users' => 0, 'documents' => 0];
            $derniers_moocs = [];
            $derniers_users = [];
        }
        
        require_once '../view/admin/dashboard.php';
    }
    
    // ========== DÉCONNEXION ==========
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        session_destroy();
        header('Location: index.php?page=admin_login');
        exit;
    }
    
    // ========== CRUD MOOCS ==========
    
    public function moocs() {
        $this->checkAdmin();
        
        $success = $_GET['success'] ?? '';
        
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT * FROM moocs ORDER BY id DESC");
            $moocs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $moocs = [];
            $error = $e->getMessage();
        }
        
        require_once '../view/admin/moocs.php';
    }
    
    public function moocCreate() {
        $this->checkAdmin();
        
        $message = '';
        $type = '';
        $isEdit = false;
        $mooc = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("INSERT INTO moocs (titre, description, image, duree, effort, rythme, video, quizz) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['description'],
                    $_POST['image'],
                    $_POST['duree'],
                    $_POST['effort'],
                    $_POST['rythme'],
                    $_POST['video'],
                    $_POST['quizz'] ?? ''
                ]);
                
                header('Location: index.php?page=admin_moocs&success=created');
                exit;
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
                $type = "danger";
            }
        }
        
        require_once '../view/admin/mooc_form.php';
    }
    
    public function moocEdit() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        $message = '';
        $type = '';
        $isEdit = true;
        
        try {
            $pdo = Database::getConnection();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $stmt = $pdo->prepare("UPDATE moocs SET titre=?, description=?, image=?, duree=?, effort=?, rythme=?, video=?, quizz=? WHERE id=?");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['description'],
                    $_POST['image'],
                    $_POST['duree'],
                    $_POST['effort'],
                    $_POST['rythme'],
                    $_POST['video'],
                    $_POST['quizz'] ?? '',
                    $id
                ]);
                
                header('Location: index.php?page=admin_moocs&success=updated');
                exit;
            }
            
            $stmt = $pdo->prepare("SELECT * FROM moocs WHERE id = ?");
            $stmt->execute([$id]);
            $mooc = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$mooc) {
                header('Location: index.php?page=admin_moocs');
                exit;
            }
            
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
            $type = "danger";
        }
        
        require_once '../view/admin/mooc_form.php';
    }
    
    public function moocDelete() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        
        try {
            $pdo = Database::getConnection();
            
            // Supprimer aussi les favoris associés
            $stmt = $pdo->prepare("DELETE FROM mooc_favoris WHERE mooc_id = ?");
            $stmt->execute([$id]);
            
            // Supprimer le MOOC
            $stmt = $pdo->prepare("DELETE FROM moocs WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: index.php?page=admin_moocs&success=deleted');
        } catch (PDOException $e) {
            header('Location: index.php?page=admin_moocs&error=delete_failed');
        }
        exit;
    }
    
    // ========== CRUD LIVRES ==========
    
    public function livres() {
        $this->checkAdmin();
        
        $success = $_GET['success'] ?? '';
        
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT * FROM livres ORDER BY id DESC");
            $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $livres = [];
            $error = $e->getMessage();
        }
        
        require_once '../view/admin/livres.php';
    }
    
    public function livreCreate() {
        $this->checkAdmin();
        
        $message = '';
        $type = '';
        $isEdit = false;
        $livre = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("INSERT INTO livres (titre, image, description) VALUES (?, ?, ?)");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['image'],
                    $_POST['description']
                ]);
                
                header('Location: index.php?page=admin_livres&success=created');
                exit;
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
                $type = "danger";
            }
        }
        
        require_once '../view/admin/livre_form.php';
    }
    
    public function livreEdit() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        $message = '';
        $type = '';
        $isEdit = true;
        
        try {
            $pdo = Database::getConnection();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $stmt = $pdo->prepare("UPDATE livres SET titre=?, image=?, description=? WHERE id=?");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['image'],
                    $_POST['description'],
                    $id
                ]);
                
                header('Location: index.php?page=admin_livres&success=updated');
                exit;
            }
            
            $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
            $stmt->execute([$id]);
            $livre = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$livre) {
                header('Location: index.php?page=admin_livres');
                exit;
            }
            
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
            $type = "danger";
        }
        
        require_once '../view/admin/livre_form.php';
    }
    
    public function livreDelete() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: index.php?page=admin_livres&success=deleted');
        } catch (PDOException $e) {
            header('Location: index.php?page=admin_livres&error=delete_failed');
        }
        exit;
    }
}
?>