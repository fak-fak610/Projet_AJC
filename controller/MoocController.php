<?php
require_once '../model/mooc.php';

class MoocController {
    public function index() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=ajc_mooc_biblio_formation;charset=utf8mb4', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ Connexion échouée : " . $e->getMessage());
        }

        // Récupérer la recherche si présente
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        // Pagination
        $moocsPerPage = 6;
        $page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $startIndex = ($page - 1) * $moocsPerPage;

        // Calcul du total selon recherche
        if ($q !== '') {
            $stmtTotal = $pdo->prepare('SELECT COUNT(*) FROM moocs WHERE titre LIKE :q');
            $stmtTotal->execute([':q' => "%$q%"]);
        } else {
            $stmtTotal = $pdo->query('SELECT COUNT(*) FROM moocs');
        }
        $totalMoocs = $stmtTotal->fetchColumn();
        $totalPages = $totalMoocs > 0 ? ceil($totalMoocs / $moocsPerPage) : 1;

        // Récupérer MOOC paginés selon recherche
        if ($q !== '') {
            $stmt = $pdo->prepare('SELECT * FROM moocs WHERE titre LIKE :q ORDER BY id LIMIT :start, :count');
            $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
            $stmt->bindValue(':start', $startIndex, PDO::PARAM_INT);
            $stmt->bindValue(':count', $moocsPerPage, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $pdo->prepare('SELECT * FROM moocs ORDER BY id LIMIT :start, :count');
            $stmt->bindValue(':start', $startIndex, PDO::PARAM_INT);
            $stmt->bindValue(':count', $moocsPerPage, PDO::PARAM_INT);
            $stmt->execute();
        }

        $currentMoocs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require '../view/mooc_view.php';
    }

    public function favorites() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // Supprimer un favori
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'supprimer_favori') {
            $mooc_id = (int)$_POST['mooc_id'];
            Mooc::removeFavori($user_id, $mooc_id);
            $message = "Favori retiré !";
        }

        // Liste des favoris
        $favoris = Mooc::getFavoris($user_id);

        require_once '../view/mes_favoris.php';
    }
}
?>
