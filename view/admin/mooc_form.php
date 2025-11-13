<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - <?php echo $isEdit ? 'Modifier' : 'Créer'; ?> MOOC</title>
<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-page">
<header class="admin-header">
<h1><?php echo $isEdit ? 'Modifier' : 'Créer'; ?> MOOC</h1>
<nav>
<a href="index.php?page=admin_moocs">Retour aux MOOCs</a>
<a href="index.php?page=admin_dashboard">Dashboard</a>
</nav>
</header>


<main class="admin-container">
<?php if (!empty($message)): ?>
<div class="alert alert-<?php echo htmlspecialchars($type ?: 'info'); ?>"><?php echo $message; ?></div>
<?php endif; ?>


<form method="post" action="index.php?page=<?php echo $action; ?>" class="form-admin">
<label>Titre
<input type="text" name="titre" value="<?php echo htmlspecialchars($mooc['titre'] ?? ''); ?>" required>
</label>


<label>Description
<textarea name="description" rows="6"><?php echo htmlspecialchars($mooc['description'] ?? ''); ?></textarea>
</label>


<label>Image (URL)
<input type="text" name="image" value="<?php echo htmlspecialchars($mooc['image'] ?? ''); ?>">
</label>


<label>Durée
<input type="text" name="duree" value="<?php echo htmlspecialchars($mooc['duree'] ?? ''); ?>">
</label>


<label>Effort
<input type="text" name="effort" value="<?php echo htmlspecialchars($mooc['effort'] ?? ''); ?>">
</label>


<label>Rythme
<input type="text" name="rythme" value="<?php echo htmlspecialchars($mooc['rythme'] ?? ''); ?>">
</label>


<label>Vidéo (URL)
<input type="text" name="video" value="<?php echo htmlspecialchars($mooc['video'] ?? ''); ?>">
</label>


<label>Quizz (HTML)
<textarea name="quizz" rows="4"><?php echo htmlspecialchars($mooc['quizz'] ?? ''); ?></textarea>
</label>


<div class="form-actions">
<button type="submit" class="btn"><?php echo $isEdit ? 'Mettre à jour' : 'Créer'; ?></button>
<a href="index.php?page=admin_moocs" class="btn btn-link">Annuler</a>
</div>
</form>
</main>
</body>
</html>