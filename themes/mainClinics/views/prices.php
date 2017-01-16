<!--ТАБЫ / Цены на исследования-->
<section id="prices">
    <h2>Цены на исследования</h2>
    <div class="row prices">
        <div class="col-md-12 col-xs-12">
            <ul class="tabs">
                <li class="active"><a href="#tab1">МРТ</a></li>
                <li class=""><a href="#tab2">КТ</a></li>
            </ul>
            <div class="tab_container">
                <div id="tab1" class="tab_content">
                    <!--МРТ головы и шеи-->
                    <table>
                        <?php
                            $module = Yii::app() -> getModule('prices');
                            $mrtPrices = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAllByAttributes(['category_name' => 'mrt']));
                            foreach($mrtPrices as $block) {
                                $this -> renderPartial('//_price_block',['block' => $block]);
                            }
                        ?>
                    </table>
                    <div class="clear"></div>
                </div>

                <div id="tab2" class="tab_content">
                    <!--КТ головы и шеи-->
                    <table>

                        <?php

                        $ktPrices = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAllByAttributes(['category_name' => 'kt_']));
                        //$ktPrices = PriceBlock::model() -> findAllByAttributes(['category_name' => 'kt_']);
                        foreach($ktPrices as $block) {
                            $this -> renderPartial('//_price_block',['block' => $block]);
                        }
                        $selPrices = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAllByAttributes(['category_name' => 'sel']));
                        foreach($selPrices as $block) {
                            $this -> renderPartial('//_price_block',['block' => $block]);
                        }
                        ?>
                    </table>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!---->

<div class="line"></div>