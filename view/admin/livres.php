<?php
// view/admin/livres.php
// Variables attendues : $livres (array), $success
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - Livres</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-page">
<header class="admin-header">
<h1>Gestion des Livres</h1>
<nav>
<a href="index.php?page=admin_dashboard">Dashboard</a>
<a href="index.php?page=admin_moocs">MOOCs</a>
<a href="index.php?page=admin_logout">Déconnexion</a>
</nav>
</header>


<main class="admin-container">
<?php if (!empty($success)): ?>
<div class="alert alert-success">Opération réussie.</div>
<?php endif; ?>


<div class="actions-row">
<a href="index.php?page=admin_livre_create" class="btn">+ Nouveau Livre</a>
</div>


<table class="admin-table">
<thead>
<tr>
<th>ID</th>
<th>Titre</th>
<th>Date ajout</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach (($livres ?? []) as $l): ?>
<tr>
<td><?php echo intval($l['id']); ?></td>
<td><?php echo htmlspecialchars($l['titre']); ?></td>
<td><?php echo htmlspecialchars($l['date_ajout'] ?? ''); ?></td>
<td>
<a href="index.php?page=admin_livre_edit&id=<?php echo intval($l['id']); ?>">Éditer</a> |
<a href="index.php?page=admin_livre_delete&id=<?php echo intval($l['id']); ?>" onclick="return confirm('Supprimer ce livre ?');">Supprimer</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</main>
</body>
</html>