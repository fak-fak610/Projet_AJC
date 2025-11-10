<!-- header_mooc.php - SANS session_start() -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - Centre AJC' : 'Centre AJC - MOOC' ?></title>  <!-- Titre dynamique (définit $page_title dans la page principale) -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Styles globaux -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Header spécifique MOOC -->
    <link rel="stylesheet" href="css/header_mooc.css">
    <!-- Styles spécifiques à la page MOOC (conditionnel si besoin ; retirez si pas pour toutes les pages) -->
    <link rel="stylesheet" href="css/mooc.css">
    <!-- CSS pour pages spécifiques (ex. : favoris) - Ajoutez d'autres si besoin -->
    <?php if (basename($_SERVER['PHP_SELF']) === 'mes_favoris.php'): ?>
        <link rel="stylesheet" href="css/mes_favoris.css">
    <?php endif; ?>
</head>
<body class="mooc-page">

<header class="header-mooc bg-dark py-3 mb-4">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <!-- Logo gauche -->
            <a href="index.php" class="d-flex align-items-center me-3">
                <img src="assets/images/logo ajc.png" alt="Logo Centre AJC" width="90">  <!-- Vérifiez que l'image existe -->
            </a>

            <!-- Navigation -->
            <nav class="flex-grow-1">
                <ul class="nav justify-content-center align-items-center mb-0">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="mooc.php">MOOC</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="formations.php">Formations</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="bibliotheque.php">Bibliothèque</a></li>
                    <!-- "Mes favoris" SEULEMENT si connecté -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link text-white" href="mes_favoris.php"><i class="fas fa-heart"></i> Mes favoris</a></li>
                    <?php endif; ?>
                    <!-- Liens utilisateur conditionnels -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link text-white" href="profil.php"><i class="fas fa-user"></i> Mon profil</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link text-white" href="connexion.php"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="inscription.php"><i class="fas fa-user-plus"></i> Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <!-- Barre de recherche (seulement si pas sur page login/inscription, ex. : conditionnel) -->
        <?php if (!in_array(basename($_SERVER['PHP_SELF']), ['connexion.php', 'inscription.php'])): ?>
            <div class="row mt-3 justify-content-center">
                <div class="col-auto px-0 header-mooc-search-col">
                    <form method="get" action="mooc.php" class="input-group">
                        <input type="text" name="q" class="form-control py-2 border-end-0" placeholder="Rechercher un MOOC..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                        <button class="btn btn-outline-light border-start-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
