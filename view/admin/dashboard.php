
<?php
// view/admin/dashboard.php
// Variables attendues : $stats (array), $derniers_moocs, $derniers_users
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - Dashboard</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-page">
<header class="admin-header">
<h1>Tableau de bord</h1>
<nav>
<a href="index.php?page=admin_dashboard">Dashboard</a>
<a href="index.php?page=admin_moocs">MOOCs</a>
<a href="index.php?page=admin_livres">Livres</a>
<a href="index.php?page=admin_logout">Déconnexion</a>
</nav>
</header>


<main class="admin-container">
<section class="stats">
<div class="stat-card">MOOCs<br><strong><?php echo intval($stats['moocs'] ?? 0); ?></strong></div>
<div class="stat-card">Livres<br><strong><?php echo intval($stats['livres'] ?? 0); ?></strong></div>
<div class="stat-card">Utilisateurs<br><strong><?php echo intval($stats['users'] ?? 0); ?></strong></div>
<div class="stat-card">Documents<br><strong><?php echo intval($stats['documents'] ?? 0); ?></strong></div>
</section>


<section class="recent">
<h2>Derniers MOOCs</h2>
<ul>
<?php foreach (($derniers_moocs ?? []) as $m): ?>
<li><?php echo htmlspecialchars($m['titre']); ?> — <?php echo htmlspecialchars($m['date']); ?></li>
<?php endforeach; ?>
</ul>


<h2>Derniers utilisateurs</h2>
<ul>
<?php foreach (($derniers_users ?? []) as $u): ?>
<li><?php echo htmlspecialchars($u['username']); ?> (ID <?php echo intval($u['id']); ?>)</li>
<?php endforeach; ?>
</ul>
</section>
</main>
</body>
</html>