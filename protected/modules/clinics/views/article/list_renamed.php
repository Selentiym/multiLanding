<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.02.2017
 * Time: 19:01
 * @type ArticleController $this
 * @type Article[] $models
 */
foreach($models as $a){
    echo "<p>".CHtml::link($a -> name, $this -> createUrl('article/view',['verbiage' => $a -> verbiage]))."</p>";
}