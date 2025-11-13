<?php
// view/admin/moocs.php
// Variables attendues : $moocs (array), $success (optionnel)
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - MOOCs</title>
<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-page">
<header class="admin-header">
<h1>Gestion des MOOCs</h1>
<nav>
<a href="index.php?page=admin_dashboard">Dashboard</a>
<a href="index.php?page=admin_livres">Livres</a>
<a href="index.php?page=admin_logout">Déconnexion</a>
</nav>
</header>


<main class="admin-container">
<?php if (!empty($success)): ?>
<div class="alert alert-success">Opération réussie.</div>
<?php endif; ?>


<div class="actions-row">
<a href="index.php?page=admin_mooc_create" class="btn">+ Nouveau MOOC</a>
</div>


<table class="admin-table">
<thead>
<tr>
<th>ID</th>
<th>Titre</th>
<th>Date</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach (($moocs ?? []) as $m): ?>
<tr>
<td><?php echo intval($m['id']); ?></td>
<td><?php echo htmlspecialchars($m['titre']); ?></td>
<td><?php echo htmlspecialchars($m['date']); ?></td>
<td>
<a href="index.php?page=admin_mooc_edit&id=<?php echo intval($m['id']); ?>">Éditer</a> |
<a href="index.php?page=admin_mooc_delete&id=<?php echo intval($m['id']); ?>" onclick="return confirm('Supprimer ce MOOC ?');">Supprimer</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</main>
</body>
</html>