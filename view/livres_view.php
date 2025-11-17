<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque numérique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ton CSS -->
    <link rel="stylesheet" href="/projet_ajc_php/assets/css/bibli.css?v=1.5">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Bannière -->
<div class="banniere-europeana">
  <div class="overlay-flou">
    <h1>Découvrez le patrimoine culturel numérique</h1>
    <p>Découvrez nos livres et ressources en ligne ?</p>
  </div>
</div>

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

<!-- SECTION LIVRES -->
<section class="explore-themes" id="carrousel-livres">
  <h2>Explorez par thème</h2>

  <div class="carousel-container">
    <button class="prev">&#10094;</button>

    <div class="carousel">
      <!-- LIVRES x1 -->
      <?php foreach ($livres as $livre): ?>
        <div class="card">
          <?php
          $imageSrc = htmlspecialchars($livre['image']);
          if (filter_var($imageSrc, FILTER_VALIDATE_URL)) {
              // URL externe
              $finalSrc = $imageSrc;
          } else {
              // Chemin local
              $finalSrc = '/projet_ajc_php/' . $imageSrc;
          }
          ?>
          <img src="<?= $finalSrc ?>" alt="<?= htmlspecialchars($livre['titre']) ?>" onerror="this.src='/projet_ajc_php/assets/images/placeholder.png'">
          <p><?= htmlspecialchars($livre['titre']) ?></p>
        </div>
      <?php endforeach; ?>

      <!-- LIVRES x2 (pour infini) -->
      <?php foreach ($livres as $livre): ?>
        <div class="card">
          <?php
          $imageSrc = htmlspecialchars($livre['image']);
          if (filter_var($imageSrc, FILTER_VALIDATE_URL)) {
              // URL externe
              $finalSrc = $imageSrc;
          } else {
              // Chemin local
              $finalSrc = '/projet_ajc_php/' . $imageSrc;
          }
          ?>
          <img src="<?= $finalSrc ?>" alt="<?= htmlspecialchars($livre['titre']) ?>" onerror="this.src='/projet_ajc_php/assets/images/placeholder.png'">
          <p><?= htmlspecialchars($livre['titre']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <button class="next">&#10095;</button>
  </div>
</section>


<script>
const carousel = document.querySelector('.carousel');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');

// Flèches
prev.addEventListener('click', () => {
    carousel.scrollBy({ left: -250, behavior: 'smooth' });
});
next.addEventListener('click', () => {
    carousel.scrollBy({ left: 250, behavior: 'smooth' });
});

// Scroll infini automatique
let autoScroll = setInterval(() => {
    if (carousel.scrollLeft >= (carousel.scrollWidth / 2)) {
        carousel.scrollLeft = 0;
    }
    carousel.scrollLeft += 2;
}, 20);

// Reset scroll après clic flèche
function restartAuto() {
    clearInterval(autoScroll);
    setTimeout(() => {
        autoScroll = setInterval(() => {
            if (carousel.scrollLeft >= (carousel.scrollWidth / 2)) {
                carousel.scrollLeft = 0;
            }
            carousel.scrollLeft += 2;
        }, 20);
    }, 800);
}

prev.addEventListener('click', restartAuto);
next.addEventListener('click', restartAuto);
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>