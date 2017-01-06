<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 16:31
 */
?>


<section class="block-prices">
    <div class="container container-shift">


        <div class="navigation default" id="navigation">
            <p>Цены на МРТ и КТ:</p>
            <ul>
                <li><a id="price_head" href="#mrt-head" title="МРТ и КТ головы и шеи"></a></li>
                <li><a id="price_pozv" href="#mrt-pozv" title="МРТ и КТ позвоночника"></a></li>
                <li><a id="price_br" href="#mrt-br" title="МРТ и КТ брюшной полости"></a></li>
                <li><a id="price_taz" href="#mrt-taz" title="МРТ и КТ органов малого таза"></a></li>
                <li><a id="price_sust" href="#mrt-sust" title="МРТ и КТ суставов"></a></li>
                <li><a id="price_org" href="#mrt-org" title="МРТ и КТ органов"></a></li>
                <li><a id="price_heart" href="#mrt-serd" title="МРТ и КТ сердца и сосудов"></a></li>
                <li><a id="price_kon" href="#mrt-kon" title="МРТ и КТ конечностей"></a></li>
                <li><a id="price_grud" href="#mrt-grud" title="МРТ и КТ грудной клетки"></a></li>
            </ul>
        </div>
        <div class="navigation navigation-mobile" id="navigation-mobile">
            <p>Цены на МРТ и КТ:</p>
            <ul>
                <li><a href="#mrt-head" title="МРТ и КТ головы и шеи"></a></li>
                <li><a href="#mrt-pozv" title="МРТ и КТ позвоночника"></a></li>
                <li><a href="#mrt-br" title="МРТ и КТ брюшной полости"></a></li>
                <li><a href="#mrt-taz" title="МРТ и КТ органов малого таза"></a></li>
                <li><a href="#mrt-sust" title="МРТ и КТ суставов"></a></li>
                <li><a href="#mrt-org" title="МРТ и КТ органов"></a></li>
                <li><a href="#mrt-serd" title="МРТ и КТ сердца и сосудов"></a></li>
                <li><a href="#mrt-kon" title="МРТ и КТ конечностей"></a></li>
                <li><a href="#mrt-grud" title="МРТ и КТ грудной клетки"></a></li>
            </ul>
        </div>

        <h1 style="margin-bottom: 0;">Цены МРТ и КТ</h1>
        <div class="vrezka" style="font-size:17px;">
            <div>
                <p>Мы решили снизить цены на МРТ и КТ диагностику, сделав этот метод более доступным! </p>
                <p> В наших клиниках Вы сможете:</p>
                <ul>
                    <li><img src="<?php echo $base; ?>/img/galka.png"> найти лучшую цену в городе</li>
                    <li><img src="<?php echo $base; ?>/img/galka.png"> пройти МРТ и КТ исследование рядом с домом</li>
                </ul>
            </div>
        </div>
        <ul id="price">
            <?php
            //Нашли все блоки.

            /*$blocks = PriceBlock::model() -> findAll(array('order' => '`num` ASC'));
            foreach (array_reverse($model -> prices) as $price) {
                //Перемещаем блоки с нужными ценами в начало массива
                $block = $price -> block;
                $key = array_search($block, $blocks);
                array_splice($blocks,$key,1);
                array_unshift($blocks,$block);
            }*/
            $module = Yii::app() -> getModule('prices');
            /**
             * @type PricesModule $module
             */
            $blocks = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAll(array('order' => '`num` ASC')));
            foreach($blocks as $key => $block){
                $this -> renderPartial('//prices/_price_block_module',array(
                    'block' => $block,
                ));
            }
            /*$prev = NULL;
            $light = array_reverse(CHtml::giveAttributeArray($model -> prices, 'id'));
            foreach($blocks as $key => $block){
                $this -> renderPartial('//prices/_price_block_module',array(
                    'prev' => $prev,
                    'block' => $block,
                    'highlight' => $light
                ));
                $prev = $block;
            }*/
            ?>
        </ul>
    </div>
</section>



