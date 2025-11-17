<?php
class UploadHelper {
    
    /**
     * Upload une image (JPEG, PNG, GIF)
     * @param array $file - Le fichier $_FILES['nom_du_champ']
     * @param string $destination - Dossier de destination (ex: 'moocs/images')
     * @return string|false - Chemin du fichier uploadé ou false en cas d'erreur
     */
    public static function uploadImage($file, $destination) {
        // Extensions autorisées
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxSize = 5 * 1024 * 1024; // 5 Mo
        
        return self::uploadFile($file, $destination, $allowedExtensions, $maxSize);
    }
    
    /**
     * Upload une vidéo (MP4, AVI, MOV, WEBM)
     * @param array $file - Le fichier $_FILES['nom_du_champ']
     * @param string $destination - Dossier de destination (ex: 'moocs/videos')
     * @return string|false - Chemin du fichier uploadé ou false en cas d'erreur
     */
    public static function uploadVideo($file, $destination) {
        // Extensions autorisées
        $allowedExtensions = ['mp4', 'avi', 'mov', 'webm', 'mkv'];
        $maxSize = 100 * 1024 * 1024; // 100 Mo

        return self::uploadFile($file, $destination, $allowedExtensions, $maxSize);
    }

    /**
     * Upload un fichier audio (MP3, WAV, OGG, AAC)
     * @param array $file - Le fichier $_FILES['nom_du_champ']
     * @param string $destination - Dossier de destination (ex: 'moocs/audios')
     * @return string|false - Chemin du fichier uploadé ou false en cas d'erreur
     */
    public static function uploadAudio($file, $destination) {
        // Extensions autorisées
        $allowedExtensions = ['mp3', 'wav', 'ogg', 'aac', 'm4a'];
        $maxSize = 50 * 1024 * 1024; // 50 Mo

        return self::uploadFile($file, $destination, $allowedExtensions, $maxSize);
    }

    /**
     * Upload un fichier générique
     */
    public static function uploadFile($file, $destination, $allowedExtensions, $maxSize) {
        return self::uploadFilePrivate($file, $destination, $allowedExtensions, $maxSize);
    }

    /**
     * Upload un fichier générique (documents, etc.)
     * @param array $file - Le fichier $_FILES['nom_du_champ']
     * @param string $destination - Dossier de destination (ex: 'livres/files')
     * @param array $allowedExtensions - Extensions autorisées
     * @param int $maxSize - Taille maximale en octets
     * @return string|false - Chemin du fichier uploadé ou false en cas d'erreur
     */
    public static function uploadGenericFile($file, $destination, $allowedExtensions, $maxSize) {
        return self::uploadFilePrivate($file, $destination, $allowedExtensions, $maxSize);
    }

    // Renommer la méthode private en :
    private static function uploadFilePrivate($file, $destination, $allowedExtensions, $maxSize) {
        // Vérifier si le fichier existe
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return false; // Pas de fichier uploadé
        }
        
        // Vérifier les erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors de l'upload du fichier (code: {$file['error']})");
        }
        
        // Vérifier la taille
        if ($file['size'] > $maxSize) {
            $maxSizeMB = $maxSize / (1024 * 1024);
            throw new Exception("Le fichier est trop volumineux (max {$maxSizeMB} Mo)");
        }
        
        // Vérifier l'extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Extension non autorisée. Formats acceptés : " . implode(', ', $allowedExtensions));
        }
        
        // Créer le dossier si nécessaire
        $uploadDir = "../uploads/{$destination}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Générer un nom unique
        $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
        $filePath = $uploadDir . $newFileName;
        
        // Déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Erreur lors du déplacement du fichier");
        }
        
        // Retourner le chemin relatif (pour stockage en BDD)
        return "uploads/{$destination}/" . $newFileName;
    }
    
    /**
     * Supprimer un fichier uploadé
     * @param string $filePath - Chemin du fichier (ex: 'uploads/moocs/images/123456.jpg')
     * @return bool
     */
    public static function deleteFile($filePath) {
        $fullPath = "../{$filePath}";
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
    
    /**
     * Vérifier si c'est une URL externe
     * @param string $path
     * @return bool
     */
    public static function isExternalUrl($path) {
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }
}
?>