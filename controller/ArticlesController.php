// controller/ArticlesController.php
<?php
require_once('../model/Article.php');

class ArticlesController {
    public function index() {
        $articles = Article::getAll();

        // Ajout des liens connexes aussi (comme dans ton code d'origine)
        $liensConnexes = [
            ['type' => 'video', 'src' => 'https://www.youtube.com/embed/X2wa7qEmVbo?feature=oembed', 'title' => 'Bibliothèque moderne'],
            ['type' => 'video', 'src' => 'https://www.youtube.com/embed/0s_CxsussFE?feature=oembed', 'title' => 'Incorporer le numérique dans le système éducatif'],
            ['type' => 'video', 'src' => 'https://www.youtube.com/embed/G16_BwSeEjk?feature=oembed', 'title' => 'Sécurisez votre présence sur le web'],
            ['type' => 'video', 'src' => 'https://www.youtube.com/embed/4Ppu8LvjgZM?feature=oembed', 'title' => 'Les MOOCs expliqués']
        ];

        include('../view/articles_view.php');
    }
}
?>