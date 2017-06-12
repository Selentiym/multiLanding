<?php
/**
 *
 * @var Article[] $articles
 */
foreach ($articles as $article) {
    /**
     * @type Article $article
     */
    echo "<div class='col-12 col-md-4'>";
    $this -> renderPartial('/article/_shortcut',['model' => $article]);
    echo "</div>";
}