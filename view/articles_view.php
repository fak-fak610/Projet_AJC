<?php include '../includes/header.php'; ?>

<!-- === Carrousel principal (images de couverture) === -->
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $images = [
            "https://ibp.info6tm.fr/api/v1/files/64c26f00e7e71824dc05811b/methodes/article_small/image.jpg",
            "https://informatique-pour-entrepreneurs.fr/wp-content/uploads/2024/09/what-are-the-most-effective-digital-library-management-software.jpeg",
            "https://media.meer.com/attachments/5e2d03168bf2aa032512a106e099e0c868cea082/store/fill/860/645/c83877e28d579dbecb43d67a41cba28e965d78035a85772ed922c748909c/La-constitution-dune-bibliotheque-numerique.jpg",
            "https://actualitte.com/uploads/images/6912266783_5718002ae1_z-f62cdf78-cb2d-4284-a589-a397aa22a928.jpg",
        ];

        foreach ($images as $index => $url) {
            $active = $index === 0 ? 'active' : '';
            echo "
                <div class='carousel-item $active'>
                    <img src='$url' class='d-block w-100 img-fluid' alt='carousel image $index' style='object-fit: cover; max-height: 500px;'>
                </div>
            ";
        }
        ?>
    </div>

    <!-- Flèches du premier carrousel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>

<!-- === Section Articles === -->
<div class="container mt-5 text-center">
    <h1 class="display-5 fw-bold">Articles</h1>
    <p class="lead">Découvrez nos derniers articles pour rester informé sur les tendances, innovations et actualités de notre secteur.</p>

    <!-- Boutons catégories -->
    <div class="row mt-4 justify-content-center">
        <?php
        $categories = [
            ['label' => 'Bibliothèque', 'url' => 'index.php?page=bibliotheque'],
            ['label' => 'Articles', 'url' => 'index.php?page=articles'],
            ['label' => 'Documents', 'url' => 'index.php?page=doc'],
            ['label' => 'Livres', 'url' => 'index.php?page=livres'],
        ];
        foreach ($categories as $cat): ?>
            <div class="col-6 col-md-2 mb-2">
                <a href="<?= $cat['url'] ?>" class="btn btn-outline-dark w-100"><?= htmlspecialchars($cat['label']) ?></a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- === Carrousel Articles === -->
    <p class="lead mt-5">Nouveautés</p>

    <div id="articleCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-inner">
            <?php foreach ($articles as $index => $n): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="position-relative text-white">
                        <img 
                            src="<?= htmlspecialchars(!empty($n['img']) 
                                ? '/projet_ajc_php100/assets/images/' . $n['img'] 
                                : 'https://d3f1iyfxxz8i1e.cloudfront.net/courses/course_image/34ec54c450f7.png') ?>" 
                            class="d-block w-100 img-fluid" 
                            style="max-height: 450px; object-fit: cover;" 
                            alt="Révolution pédagogique - Mooc AJC"
                        >
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                            <h5>Révolution pédagogique : Le Mooc AJC</h5>
                            <p>Découvrez comment les nouvelles technologies transforment l'apprentissage à distance.</p>
                            <a href="index.php?page=mooc_revolution" class="btn btn-light btn-sm">Découvrir le Mooc</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Flèches du carrousel articles (?? replacées à l’intérieur) -->
        <button class="carousel-control-prev" type="button" data-bs-target="#articleCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#articleCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <!-- === Contenus liés === -->
    <h4 class="mb-4 text-center">Contenus liés</h4>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <?php foreach ($liensConnexes as $item): ?>
            <div class="col">
                <div class="card h-100">
                    <?php if ($item['type'] === 'img'): ?>
                        <img src="<?= htmlspecialchars($item['src']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>" style="height: 180px; object-fit: cover;">
                    <?php else: ?>
                        <div class="ratio ratio-16x9">
                            <iframe src="<?= htmlspecialchars($item['src']) ?>" title="<?= htmlspecialchars($item['title']) ?>" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <p class="card-text text-truncate"><?= htmlspecialchars($item['title']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>