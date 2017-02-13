<?php
/**
 *
 * @var AdminController $this
 * @var \PriceList $model
 * @var integer $object_id
 * @var clinics|doctors $object
 *
 * @type ObjectPriceBlock[] $blocks
 */
$o = Objects::getNumber(get_class($object));
$blocks = ObjectPriceBlock::model() -> findAll(['order' => 'num DESC']);
?>
<h1>Прайслист <?php echo get_class($object) == 'clinics' ? 'клиники' : 'доктора'; ?> <<?php echo $object -> name; ?>></h1>
<style>
    table tr td{
        border: 1px solid black;
        vertical-align: middle;
        padding:2px;
    }
    table tr {
        text-align: center;
    }
</style>
<form method="post">
<table class="items" style="width:80%; margin:0 auto;">
    <tr>
        <th>Тип</th>
        <th>Блок</th>
        <th>Имя</th>
        <th>Значение</th>
    </tr>
<?php
foreach ($blocks as $block) {
    foreach ($block -> prices as $price) {
        if ($price -> object_type == $o) {
            $this->renderPartial('/prices/_objectPriceForm', ['object' => $object, 'model' => $price]);
        }
    }
}
?>
</table>
    <input type="submit" value="Сохранить"/>
</form>
