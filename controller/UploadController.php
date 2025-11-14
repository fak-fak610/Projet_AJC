<?php
require_once __DIR__ . '/../config.php';

class UploadController {
    
    public function index() {
        $this->upload();
    }

    public function upload() {
        // ? Vérifie si la session n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $message = '';
        $type = '';

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $message = "Vous devez être connecté pour uploader un document.";
            $type = "danger";
        } else {
            // Traitement de l'upload
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
                $file = $_FILES['document'];
                $userId = $_SESSION['user_id'];
                
                // Extensions autorisées
                $allowedExtensions = ['pdf', 'doc', 'docx', 'pptx', 'txt', 'odt', 'xlsx'];
                $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                
                // Vérifications
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $message = "Erreur lors de l'upload du fichier.";
                    $type = "danger";
                } elseif (!in_array($fileExtension, $allowedExtensions)) {
                    $message = "Extension non autorisée. Formats acceptés : " . implode(', ', $allowedExtensions);
                    $type = "danger";
                } elseif ($file['size'] > 10 * 1024 * 1024) { // 10 Mo max
                    $message = "Le fichier est trop volumineux (max 10 Mo).";
                    $type = "danger";
                } else {
                    // Créer le dossier si nécessaire
                    $uploadDir = '../documents_biblio/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    // Nom unique pour éviter les collisions
                    $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
                    $destination = $uploadDir . $newFileName;
                    
                    // Déplacer le fichier
                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        // Enregistrer dans la base de données
                        try {
                            $pdo = Database::getConnection();
                            $stmt = $pdo->prepare("INSERT INTO documents_user (nom, chemin, upload_time) VALUES (?, ?, NOW())");
                            $stmt->execute([$file['name'], $destination]);
                            
                            $message = "Document uploadé avec succès !";
                            $type = "success";
                        } catch (PDOException $e) {
                            $message = "Erreur lors de l'enregistrement en base de données : " . $e->getMessage();
                            $type = "danger";
                        }
                    } else {
                        $message = "Erreur lors du déplacement du fichier.";
                        $type = "danger";
                    }
                }
            }
        }

        // Récupérer tous les documents
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT * FROM documents_user ORDER BY upload_time DESC");
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $documents = [];
            if (empty($message)) {
                $message = "Erreur lors de la récupération des documents : " . $e->getMessage();
                $type = "danger";
            }
        }

        // Charger la vue
        require_once '../view/upload_view.php';
    }
}
?>