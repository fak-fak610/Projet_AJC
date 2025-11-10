<?php
// Active les erreurs pour débogage (enlève ces 2 lignes après tests)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../model/User.php';

class HomeController {
    public function index() {
        // Connexion à la base de données
        try {
            $pdo = new PDO(
                'mysql:host=localhost;dbname=ajc_mooc_biblio_formation;charset=utf8mb4',
                'root',
                ''
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ Connexion échouée : " . $e->getMessage());
        }

        // --- Récupère les 6 derniers MOOC ajoutés ---
        $stmt = $pdo->query('SELECT id, titre, description, image FROM moocs ORDER BY id DESC LIMIT 6');
        $coursAlaUne = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // --- Récupère les 3 derniers livres ---
        $stmtLivres = $pdo->query('SELECT id, titre, description, image FROM livres ORDER BY id DESC LIMIT 3');
        $livres = $stmtLivres->fetchAll(PDO::FETCH_ASSOC);

        // --- Récupère les 3 dernières actualités locales ---
        $stmtActu = $pdo->query('SELECT titre, date_evt, texte FROM actualites ORDER BY date_evt DESC LIMIT 3');
        $actus = $stmtActu->fetchAll(PDO::FETCH_ASSOC);

        // --- Actualités éducatives (NewsAPI) - Marche maintenant avec ta clé valide ---
        $newsApiKey = '66e1912347f046faaa18a34308734930'; // Ta clé valide (ne change pas si ça marche !)
        $newsUrl = "https://newsapi.org/v2/everything?q=education&language=fr&pageSize=3&sortBy=publishedAt&apiKey=$newsApiKey";

        $news = [];
        $ch = curl_init($newsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Pour tests ; active en prod
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; PHP curl)'); // Évite les blocages
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response && $httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['status']) && $data['status'] === 'ok' && !empty($data['articles'])) {
                // Filtrage : on garde seulement les articles avec image, titre et description
                $validArticles = array_filter($data['articles'], function ($article) {
                    return !empty($article['urlToImage']) && !empty($article['title']) && !empty($article['description']);
                });

                // On garde les 3 premiers articles valides
                $news = array_slice(array_values($validArticles), 0, 3);
                error_log("NewsAPI Success: " . count($news) . " articles valides récupérés");
            } else {
                error_log("NewsAPI Error: " . ($data['message'] ?? 'Unknown error') . " | HTTP: $httpCode");
            }
        } else {
            error_log("NewsAPI cURL Error: HTTP $httpCode | Response: " . substr($response, 0, 200));
        }

        // --- Récupère les 3 dernières émissions France Culture via l'API Radio France (Query grid mise à jour) ---
        $radioApiKey = '4a55b1c6-009b-4c46-b233-41bbd680abdc'; // Ta clé valide
        $radioUrl = "https://openapi.radiofrance.fr/v1/graphql";

        // Timestamps pour les dernières 24h (change 86400 en 604800 pour 7 jours si besoin)
        $start = time() - 86400; // Il y a 24h
        $end = time(); // Maintenant

        $query = <<<GQL
{
  grid(
    start: $start
    end: $end
    station: FRANCECULTURE
    includeTracks: false
  ) {
    ... on DiffusionStep {
      id
      diffusion {
        id
        title
        standFirst
        url
        published_date
        podcastEpisode {
          id
          title
          url
          playerUrl
          created
          duration
        }
      }
    }
    ... on TrackStep {
      id
      track {
        id
        title
        albumTitle
      }
    }
    ... on BlankStep {
      id
      title
    }
  }
}
GQL;

        $ch = curl_init($radioUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "X-Token: $radioApiKey"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Pour tests ; active en prod
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; PHP curl)'); // Évite les blocages

        $response = curl_exec($ch);

        if ($response === false) {
            $curlError = curl_error($ch);
            curl_close($ch);
            error_log("Radio France cURL Error: $curlError");
            $radioShows = [];
        } else {
            curl_close($ch);
            $data = json_decode($response, true);
            $radioShows = [];

            if (!empty($data['data']['grid'])) {
                // Filtre seulement les DiffusionStep et limite à 3
                $diffusions = array_filter($data['data']['grid'], function($step) {
                    return isset($step['diffusion']); // Seulement les émissions
                });
                $radioShows = array_slice(array_values($diffusions), 0, 3); // Limite à 3
                error_log("Radio France Success: " . count($radioShows) . " diffusions récupérées");
            } else {
                error_log("Radio France API Error: " . json_encode($data['errors'] ?? 'No data or unknown error'));
            }
        }

        // 🔹 Envoi à la vue
        $data = [
            'coursAlaUne' => $coursAlaUne,
            'livres' => $livres,
            'actus' => $actus,
            'news' => $news,
            'radioShows' => $radioShows
        ];

        extract($data);
        require_once '../view/home_view.php';
    }
}
?>
