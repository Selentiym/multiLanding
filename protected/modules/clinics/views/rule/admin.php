<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 23:25
 */
foreach (Article::$types as $id => $type) {
    echo "<div><a href='".$this -> createUrl('admin/RuleList',['type' => $id])."'>$type</a></div>";
}