<?php include '../includes/header.php'; ?>

<!-- Bannière hero style Europeana -->
<div class="banniere-europeana">
  <div class="overlay-flou">
    <h1>Découvrez le patrimoine culturel numérique</h1>
    <p>Découvrez nos livres et ressources en ligne ✨</p>
  </div>
</div>

<!-- === Début Carrousel Explorez par thème === -->
<section class="explore-themes" id="carrousel-livres">
  <h2>Explorez par thème</h2>
  <div class="carousel-container">
    <button class="prev">&#10094;</button>
    <div class="carousel">
      <?php foreach($livres as $livre): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
          <p><?= htmlspecialchars($livre['titre']) ?></p>
        </div>
      <?php endforeach; ?>
      <?php foreach($livres as $livre): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
          <p><?= htmlspecialchars($livre['titre']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="next">&#10095;</button>
  </div>
</section>

<section class="container py-5">
  <h2 class="mb-4 fw-bold">📖 Dernières histoires</h2>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="https://picsum.photos/400/250?random=1" class="card-img-top" alt="Image histoire 1">
        <div class="card-body">
          <h5 class="card-title">L'évolution de l'informatique</h5>
          <p class="card-text text-muted">Découvrez comment l'informatique a évolué depuis ses débuts jusqu'à aujourd'hui.</p>
          <a href="#" class="btn btn-outline-primary btn-sm">Lire plus</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="https://picsum.photos/400/250?random=2" class="card-img-top" alt="Image histoire 2">
        <div class="card-body">
          <h5 class="card-title">Les pionniers du web</h5>
          <p class="card-text text-muted">Retour sur les personnes qui ont façonné le web que nous connaissons.</p>
          <a href="#" class="btn btn-outline-primary btn-sm">Lire plus</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="https://picsum.photos/400/250?random=3" class="card-img-top" alt="Image histoire 3">
        <div class="card-body">
          <h5 class="card-title">Vers l'intelligence artificielle</h5>
          <p class="card-text text-muted">Une plongée dans l'avenir de l'IA et ses impacts sur notre quotidien.</p>
          <a href="#" class="btn btn-outline-primary btn-sm">Lire plus</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
const carousel = document.querySelector('.carousel');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');

prev.addEventListener('click', () => {
    carousel.scrollBy({ left: -200, behavior: 'smooth' });
});

next.addEventListener('click', () => {
    carousel.scrollBy({ left: 200, behavior: 'smooth' });
});

// Auto-scroll continu
let scrollAmount = 0;
setInterval(() => {
    scrollAmount += 2; // vitesse du défilement
    if(scrollAmount >= carousel.scrollWidth / 2) {
        scrollAmount = 0; // boucle
        carousel.scrollTo({ left: 0 });
    }
    carousel.scrollBy({ left: 2 });
}, 20);
</script>

<?php include '../includes/footer.php'; ?>
