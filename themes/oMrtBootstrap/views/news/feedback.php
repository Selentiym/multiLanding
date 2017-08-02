<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.08.2017
 * Time: 9:57
 */
$data = $_GET;
$page = $data['page'] > 0 ? $data['page'] : 1;
$pageSize = 20;
$criteria = new CDbCriteria();
//Только акциии партнеров
$criteria -> addCondition('clinic.partner = 1');
//1 добавили, чтобы выводить кнопку или нет.
$criteria -> limit = $pageSize + 1;
$criteria -> offset = $pageSize * ($page-1);
$newss = News::newsPageByCriteria($data, $criteria);
for ($i = 0; $i < $pageSize; $i++) {
    $news = current($newss);
    next($newss);
    if ($news instanceof News) {
        $this -> renderPartial('/news/_imagedShortcut', ['model' => $news]);
    } else {
        break;
    }
}
//Если последняя выбранная новость еще существует, то можно попробовать нажать кнопочку еще разок
if (current($newss)) {
    $this -> renderPartial('/news/_showMoreButton',['page' => $page + 1, 'area' => $data['area']]);
}
