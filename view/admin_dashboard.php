<?php
// Inclure la protection d'accès admin
include '../includes/admin_check.php';

// Inclure le header après la vérification (pour éviter les erreurs)
include '../includes/header.php';
?>

<main class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Panneau d'administration</h1>

            <div class="row g-4">
                <!-- Statistiques -->
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Utilisateurs inscrits</h5>
                            <h2 class="mb-0">
                                <?php
                                // Exemple de requête pour compter les utilisateurs
                                // $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                                // echo $stmt->fetchColumn();
                                echo "1,234"; // Valeur exemple
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">MOOCs actifs</h5>
                            <h2 class="mb-0">
                                <?php
                                // Exemple de requête pour compter les MOOCs
                                // $stmt = $pdo->query("SELECT COUNT(*) FROM moocs WHERE status = 'active'");
                                // echo $stmt->fetchColumn();
                                echo "89"; // Valeur exemple
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Commentaires en attente</h5>
                            <h2 class="mb-0">
                                <?php
                                // Exemple de requête pour compter les commentaires en attente
                                // $stmt = $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'pending'");
                                // echo $stmt->fetchColumn();
                                echo "12"; // Valeur exemple
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions administratives -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3>Actions rapides</h3>
                    <div class="list-group">
                        <a href="index.php?page=admin_users" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2"></i>Gérer les utilisateurs
                        </a>
                        <a href="index.php?page=admin_moocs" class="list-group-item list-group-item-action">
                            <i class="fas fa-graduation-cap me-2"></i>Gérer les MOOCs
                        </a>
                        <a href="index.php?page=admin_comments" class="list-group-item list-group-item-action">
                            <i class="fas fa-comments me-2"></i>Modérer les commentaires
                        </a>
                        <a href="index.php?page=admin_stats" class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-bar me-2"></i>Voir les statistiques
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
