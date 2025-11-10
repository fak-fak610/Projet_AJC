<?php
session_start();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pdo = new PDO('mysql:host=localhost;dbname=ajc_mooc_biblio_formation;charset=utf8mb4', 'root', '');
$stmt = $pdo->prepare('SELECT * FROM moocs WHERE id = :id');
$stmt->execute([':id' => $id]);
$mooc = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$mooc) {
    echo "<h1>MOOC introuvable</h1>";
    exit;
}

// Vérification connexion utilisateur
$isConnected = isset($_SESSION['user_id']);

// Gestion des favoris
$favori_ok = null;
if ($isConnected && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'favori') {
    $user_id = $_SESSION['user_id'];
    // Vérifie s'il n'est pas déjà favori
    $favCheck = $pdo->prepare("SELECT COUNT(*) FROM mooc_favoris WHERE user_id=? AND mooc_id=?");
    $favCheck->execute([$user_id, $mooc['id']]);
    if ($favCheck->fetchColumn() == 0) {
        $stmtFav = $pdo->prepare("INSERT INTO mooc_favoris (user_id, mooc_id) VALUES (?, ?)");
        $stmtFav->execute([$user_id, $mooc['id']]);
        $favori_ok = true;
    } else {
        $favori_ok = "already";
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <a href="../public/index.php?page=mooc" class="btn btn-secondary mb-3">← Retour</a>
    <h1><?= htmlspecialchars($mooc['titre'] ) ?></h1>
    <img src="<?= htmlspecialchars($mooc['image']) ?>" alt="Image MOOC" class="img-fluid mb-3" style="max-height:220px; object-fit:cover"/>

    <p class="lead"><?= htmlspecialchars($mooc['description']) ?></p>

    <div><strong>Durée :</strong> <?= htmlspecialchars($mooc['duree']) ?></div>
    <div><strong>Effort :</strong> <?= htmlspecialchars($mooc['effort']) ?></div>
    <div><strong>Rythme :</strong> <?= htmlspecialchars($mooc['rythme']) ?></div>

    <?php if (!empty($mooc['video'])): ?>
        <div class="my-4">
            <strong>Vidéo du cours :</strong>
            <!-- ===== BLOC MODIFIÉ CI-DESSOUS ===== -->
            <div class="ratio ratio-16x9">
                <video controls>
                    <source src="<?= htmlspecialchars($mooc['video']) ?>" type="video/mp4">
                    Désolé, votre navigateur ne supporte pas les vidéos intégrées.
                </video>
            </div>
            <!-- ===== FIN DU BLOC MODIFIÉ ===== -->
        </div>
    <?php endif; ?>

    <!-- Bouton Favoris -->
    <?php if ($isConnected): ?>
        <form method="post" class="mb-3">
            <input type="hidden" name="action" value="favori">
            <button type="submit" class="btn btn-warning">Ajouter aux favoris</button>
        </form>
        <?php if ($favori_ok === true): ?>
            <div class="alert alert-success">Ajouté à vos favoris !</div>
        <?php elseif ($favori_ok === "already"): ?>
            <div class="alert alert-info">Ce MOOC est déjà dans vos favoris.</div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-danger mb-3">
            Connectez-vous pour ajouter ce MOOC à vos favoris !
        </div>
    <?php endif; ?>

    <h4>Quiz</h4>
    <form method="post" action="#">
        <?= $mooc['quizz']; ?>


        <button type="submit" class="btn btn-primary mt-2">Soumettre</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
