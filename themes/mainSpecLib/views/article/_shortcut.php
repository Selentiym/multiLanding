<?php
/**
 * @var Article $model
 */
$this -> renderPartial('/article/_dumb_shortcut', [
    'url' => $this -> createUrl('home/articleView',['verbiage' => $model -> verbiage]),
    'imageUrl' => $model -> getImageUrl(),
    'text' => $model -> description,
    'name' => $model -> name
]);