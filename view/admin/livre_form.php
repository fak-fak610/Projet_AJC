
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


<form method="post" action="index.php?page=<?php echo $action; ?>" class="form-admin">
<label>Titre
<input type="text" name="titre" value="<?php echo htmlspecialchars($livre['titre'] ?? ''); ?>" required>
</label>


<label>Auteur
<input type="text" name="auteur" value="<?php echo htmlspecialchars($livre['auteur'] ?? ''); ?>" required>
</label>


<label>Description
<textarea name="description" rows="6"><?php echo htmlspecialchars($livre['description'] ?? ''); ?>"></textarea>
</label>


<label>Image (URL)
<input type="text" name="image" value="<?php echo htmlspecialchars($livre['image'] ?? ''); ?>">
</label>


<label>Fichier (URL ou chemin)
<input type="text" name="fichier" value="<?php echo htmlspecialchars($livre['fichier'] ?? ''); ?>">
</label>


<div class="form-actions">
<button type="submit" class="btn"><?php echo $isEdit ? 'Mettre à jour' : 'Créer'; ?></button>
<a href="index.php?page=admin_livres" class="btn btn-link">Annuler</a>
</div>
</form>
</main>
</body>
</html>
