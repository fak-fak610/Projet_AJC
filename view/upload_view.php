<?php include '../includes/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center mb-4">📚 Bibliothèque numérique</h1>
    <p class="text-center text-muted">Partagez et consultez des documents informatiques utiles.</p>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= htmlspecialchars($type) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Formulaire d'upload -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">📤 Partager un document informatique</h5>
                <form method="post" enctype="multipart/form-data" class="mt-3">
                    <div class="mb-3">
                        <label for="document" class="form-label">Choisir un fichier</label>
                        <input type="file" name="document" id="document" class="form-control" required>
                        <small class="text-muted">Formats autorisés : PDF, DOC, DOCX, PPTX, TXT, ODT, XLSX</small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Uploader
                    </button>
                </form>
                <p class="mt-3 mb-0 text-muted"><small>💡 <strong>Astuce :</strong> privilégiez des fichiers légers pour un accès rapide et plus écologique.</small></p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            🔒 Vous devez être <a href="index.php?page=connexion" class="alert-link">connecté</a> pour uploader des documents.
        </div>
    <?php endif; ?>

    <!-- Liste des documents -->
    <h3 class="mt-5 mb-3">📁 Documents disponibles</h3>
    <?php if (!empty($documents)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>📄 Nom du document</th>
                        <th>📅 Date d'upload</th>
                        <th>⬇️ Télécharger</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr>
                            <td><?= htmlspecialchars($doc['nom']) ?></td>
                            <td><?= date('d/m/Y à H:i', strtotime($doc['upload_time'])) ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($doc['chemin']) ?>" 
                                   class="btn btn-sm btn-outline-primary" 
                                   download>
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            ℹ️ Aucun document n'a encore été uploadé.
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>