<?php include '../includes/header.php'; ?>

    <main class="container mt-4">
        <h1 class="text-center">Formation Locale Révision AJC</h1>
        <input type="text" id="search" class="form-control my-3" placeholder="Rechercher une formation...">

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card h-100" onclick="window.location.href='formation-details.php?formation=fullstack'">
                    <img src="../assets/images/fullstack.png" class="card-img-top" alt="Développeur Web Full Stack">
                    <div class="card-body">
                        <h2 class="card-title">Développeur Web Full Stack</h2>
                        <p class="card-text">Maîtrisez les technologies du web.</p>
                        <button class="btn btn-primary">Voir la formation</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100" onclick="window.location.href='formation-details.php?formation=cybersecurite'">
                    <img src="../assets/images/cybersecurite.jpeg" class="card-img-top" alt="Cybersécurité">
                    <div class="card-body">
                        <h2 class="card-title">Cybersécurité</h2>
                        <p class="card-text">Protégez les systèmes et les réseaux.</p>
                        <button class="btn btn-primary">Voir la formation</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100" onclick="window.location.href='formation-details.php?formation=IA'">
                    <img src="../assets/images/IA.jpg" class="card-img-top" alt="Intelligence Artificielle">
                    <div class="card-body">
                        <h2 class="card-title">Intelligence Artificielle</h2>
                        <p class="card-text">Explorez l'apprentissage automatique et l'IA.</p>
                        <button class="btn btn-primary">Voir la formation</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100" onclick="window.location.href='formation-details.php?formation=donnees'">
                    <img src="../assets/images/analyse.jpg" class="card-img-top" alt="Analyse des Données">
                    <div class="card-body">
                        <h2 class="card-title">Analyse des Données</h2>
                        <p class="card-text">Apprenez à exploiter les données efficacement.</p>
                        <button class="btn btn-primary">Voir la formation</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include '../includes/footer.php'; ?>

    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                let title = card.querySelector('.card-title').innerText.toLowerCase();
                card.parentElement.style.display = title.includes(filter) ? 'block' : 'none';
            });
        });
