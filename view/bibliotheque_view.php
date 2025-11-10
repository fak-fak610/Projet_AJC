<?php include '../includes/header.php'; ?>

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $images = [
            "https://blog.editions-verone.com/wp-content/uploads/2024/03/Les-ressources-en-ligne-pour-les-ecrivains-Sites-web-forums-et-communautes-pour-trouver-du-soutien-et-des-conseils-1536x861.jpg",
            "https://maisons-alfort.fr/wp-content/uploads/2020/06/base_1110x338_livres.jpg",
            "https://www.ssf-fr.org/wp-content/uploads/2020/03/9517276783_5718002ae1_z-f62cdf78-cb2d-4284-a589-a397aa22a928.jpg",
             "https://img.freepik.com/photos-gratuite/nature-morte-livres-contre-technologie_23-2150062975.jpg",


        ];
        foreach ($images as $index => $url) {
            $active = $index === 0 ? 'active' : '';
            echo "<div class='carousel-item $active'><img src='$url' class='d-block w-100 img-fluid' alt='carousel image $index'></div>";
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>



<!-- Section principale -->

<div class="container mt-5 text-center">
    <h1 class="display-5 fw-bold">Bibliothèque numérique</h1>
    <p class="lead">Accédez à une large sélection de ressources pédagogiques pour enrichir votre apprentissage.</p>

    <?php
    $categories = [
        ['label' => 'Bibliotheque', 'url' => 'index.php?page=bibliotheque'],
        ['label' => 'Articles', 'url' => 'index.php?page=articles'],
        ['label' => 'Documents', 'url' => 'index.php?page=doc'],
        ['label' => 'Livres', 'url' => 'index.php?page=livres'],
    ];
    ?>

    <div class="row mt-4 justify-content-center">
        <?php foreach ($categories as $cat): ?>
            <div class="col-6 col-md-2 mb-2">
                <a href="<?= $cat['url'] ?>" class="btn btn-outline-dark w-100"><?= $cat['label'] ?></a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-5">
        <p class="lead">Nouveautés</p>
        <div class="row justify-content-center">
            <?php
            $nouveautes = [
                ['img' => 'https://www.2emotion.com/wp-content/uploads/2023/02/Tuto-video-5-bonnes-astuces-2-2.png', 'txt' => 'Ajout de nouveaux livres, e-books, ou articles en rapport avec les formations proposées.'],
                ['img' => 'https://static.vecteezy.com/system/resources/previews/029/927/728/non_2x/mooc-massive-open-online-course-icon-label-badge-stock-illustration-vector.jpg', 'txt' => 'Ajout de tutoriels vidéo ou de supports interactifs (MOOC, podcasts, vidéos pédagogiques).'],
                ['img' => 'https://medias.ideeup.org/banque-images/small/4905016e8ea1bf85a542e750302b000a.png', 'txt' => 'Sélection de ressources pour des périodes spécifiques (ex : rentrée, examens, orientation pro).'],
                ['img' => 'https://img.freepik.com/vecteurs-libre/illustration-du-graphique-analyse-donnees_53876-5877.jpg', 'txt' => 'Conférences avec des experts ou auteurs sur des sujets en lien avec les formations.']
            ];
            foreach ($nouveautes as $n): ?>
                <div class="col-12 col-sm-6 col-md-3 text-center mb-4">
                    <img src="<?= $n['img'] ?>" alt="nouveauté" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: cover;">
                    <p><?= $n['txt'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
