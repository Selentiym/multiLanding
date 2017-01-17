<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 17:49
 */
/**
 * @type Controller $this
 */
?>


<section id="share">
    <div class="container container-shift">
        <div class="discount">
            <p class="discount-title"><b>АКЦИЯ</b>: <?php echo $this -> renderPartial('//subs/mainPriceDiscount', ['model' => $model],true); ?></p>
            <p>до конца акции осталось:</p>
            <div class="container_countdown">
                <div id="clock" class="flip-clock-wrapper"><span class="flip-clock-divider days"><span class="flip-clock-label">Days</span></span><ul class="flip "><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">9</div></div><div class="down"><div class="shadow"></div><div class="inn">9</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">0</div></div><div class="down"><div class="shadow"></div><div class="inn">0</div></div></a></li></ul><ul class="flip "><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">0</div></div><div class="down"><div class="shadow"></div><div class="inn">0</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li></ul><span class="flip-clock-divider hours"><span class="flip-clock-label">Hours</span><span class="flip-clock-dot top"></span><span class="flip-clock-dot bottom"></span></span><ul class="flip "><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">0</div></div><div class="down"><div class="shadow"></div><div class="inn">0</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">1</div></div><div class="down"><div class="shadow"></div><div class="inn">1</div></div></a></li></ul><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">1</div></div><div class="down"><div class="shadow"></div><div class="inn">1</div></div></a></li></ul><span class="flip-clock-divider minutes"><span class="flip-clock-label">Minutes</span><span class="flip-clock-dot top"></span><span class="flip-clock-dot bottom"></span></span><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">3</div></div><div class="down"><div class="shadow"></div><div class="inn">3</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li></ul><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">6</div></div><div class="down"><div class="shadow"></div><div class="inn">6</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">5</div></div><div class="down"><div class="shadow"></div><div class="inn">5</div></div></a></li></ul><span class="flip-clock-divider seconds"><span class="flip-clock-label">Seconds</span><span class="flip-clock-dot top"></span><span class="flip-clock-dot bottom"></span></span><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">4</div></div><div class="down"><div class="shadow"></div><div class="inn">4</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">3</div></div><div class="down"><div class="shadow"></div><div class="inn">3</div></div></a></li></ul><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">3</div></div><div class="down"><div class="shadow"></div><div class="inn">3</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li></ul></div>
            </div>
        </div>
    </div>
</section>


<section>
    <div class="container container-shift">
        <div class="row">
            <div class="col-md-7">
                <p class="kons"><img src="<?php echo $base; ?>/img/galka.png"> Консультация НЕВРОЛОГА – <b>БЕСПЛАТНО</b></p>
                <p class="kons"><img src="<?php echo $base; ?>/img/galka.png"> Консультация ТРАВМАТОЛОГА  – <b>БЕСПЛАТНО</b></p>
                <p class="kons"><img src="<?php echo $base; ?>/img/galka.png"> Консультация ДИАГНОСТА  – <b>БЕСПЛАТНО</b></p>
            </div>
            <div class="col-md-5">
                <p style="text-align:center;"><img style="margin-top: 5px;" src="<?php echo $base; ?>/img/discount.png"></p>
            </div>
        </div>
        <div class="row we-are-best">
            <p>Но снизив цены, мы все равно будем лучшие, т.к.:</p>
        </div>
        <div class="row we-are-best">
            <div class="col-md-6 col-sm-6">
                <img src="<?php echo $base; ?>/img/best1.png"> <span>У нас лучшие врачи</span>
            </div>
            <div class="col-md-6 col-sm-6">
                <img src="<?php echo $base; ?>/img/best2.png"> <span>У нас лучшее в городе <br>
					оборудование</span>
            </div>
        </div>
		
        <div class="call-me">
            <p><img src="<?php echo $base; ?>/img/registration.png">Записаться на МРТ и КТ можно КРУГЛОСУТОЧНО по телефону: <b><a href="<?php echo $base; ?>/tel:<?php echo '8812'.Yii::app() -> phone -> getShort(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a></b></p>
        </div>
		
    </div>
</section>