<?php
/**
 * @var Article $model
 */
if ($model instanceof Article) {
    $data = baseSpecHelpers::articleForImagedShortcut($model);
} else {
    $data = $model;
}
$this -> renderPartial('/article/_dumb_shortcut', $data);