
<?php
// view/admin/livre_form.php
// Variables attendues : $isEdit (bool), $livre (array|null), $message, $type
$action = $isEdit ? 'admin_livre_edit&id=' . intval($_GET['id'] ?? 0) : 'admin_livre_create';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - <?php echo $isEdit ? 'Modifier' : 'Créer'; ?> Livre</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<script>
// Aperçu de l'image
function previewImage(input) {
    const preview = document.getElementById('image_preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</head>
<body class="admin-page">
<header class="admin-header">
<h1><?php echo $isEdit ? 'Modifier' : 'Créer'; ?> Livre</h1>
<nav>
<a href="index.php?page=admin_livres">Retour aux Livres</a>
<a href="index.php?page=admin_dashboard">Dashboard</a>
</nav>
</header>


<main class="admin-container">
<?php if (!empty($message)): ?>
<div class="alert alert-<?php echo htmlspecialchars($type ?: 'info'); ?>"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>


<form method="post" action="index.php?page=<?php echo $action; ?>" enctype="multipart/form-data" class="form-admin">
<label>Titre
<input type="text" name="titre" value="<?php echo htmlspecialchars($livre['titre'] ?? ''); ?>" required>
</label>


<label>Auteur
<input type="text" name="auteur" value="<?php echo htmlspecialchars($livre['auteur'] ?? ''); ?>" required>
</label>


<label>Description
<textarea name="description" rows="6"><?php echo htmlspecialchars($livre['description'] ?? ''); ?>"></textarea>
</label>


<label>Image</label>
<div class="input-group mb-2">
    <input type="text" name="image_url" placeholder="URL de l'image (ex: https://...)" value="<?php echo htmlspecialchars($livre['image'] ?? ''); ?>">
</div>
<div class="text-center my-2"><strong>OU</strong></div>
<input type="file" name="image_file" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" onchange="previewImage(this)">
<small class="text-muted">Formats acceptés : JPG, JPEG, PNG, GIF, WEBP (max 5 Mo)</small>

<?php if (!empty($livre['image'])): ?>
    <div class="mt-2">
        <img src="../<?php echo htmlspecialchars($livre['image']); ?>" id="image_preview" alt="Aperçu" style="max-width: 200px; max-height: 150px; object-fit: cover;">
    </div>
<?php else: ?>
    <img id="image_preview" src="#" alt="Aperçu" style="max-width: 200px; max-height: 150px; display: none; margin-top: 10px; object-fit: cover;">
<?php endif; ?>

<label>Fichier</label>
<div class="input-group mb-2">
    <input type="text" name="fichier_url" placeholder="URL du fichier" value="<?php echo htmlspecialchars($livre['fichier'] ?? ''); ?>">
</div>
<div class="text-center my-2"><strong>OU</strong></div>
<input type="file" name="fichier_file" accept=".pdf,.doc,.docx,.txt,.epub,.mobi,.azw,.azw3,.fb2,.rtf,.odt,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
<small class="text-muted">Formats acceptés : PDF, DOC, DOCX, TXT, EPUB, MOBI, AZW, AZW3, FB2, RTF, ODT, XLS, XLSX, PPT, PPTX, ZIP, RAR (max 50 Mo)</small>

<?php if (!empty($livre['fichier']) && !filter_var($livre['fichier'], FILTER_VALIDATE_URL)): ?>
    <div class="mt-2 alert alert-info">
        <i class="fas fa-file"></i> Fichier actuel : <?php echo basename($livre['fichier']); ?>
    </div>
<?php endif; ?>


<div class="form-actions">
<button type="submit" class="btn"><?php echo $isEdit ? 'Mettre à jour' : 'Créer'; ?></button>
<a href="index.php?page=admin_livres" class="btn btn-link">Annuler</a>
</div>
</form>
</main>
</body>
</html>
