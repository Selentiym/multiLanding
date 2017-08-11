<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.08.2017
 * Time: 15:06
 *
 * @var News $model
 * @var HomeController $this
 * @type clinics $clinic
 */
$areaVal = $model -> clinic -> getFirstTriggerValue('area');
$area = $areaVal -> verbiage;
$url = $this -> createUrl('home/showNews',['area' => $area,'id' => $model -> id],'&',false,true);
$clinic = $model -> clinic;
$cs = Yii::app() -> getClientScript();
$cs->registerLinkTag('canonical', null, $url);
$this -> setPageTitle($model -> heading ? $model -> heading : 'Акции и скидки в '.$model -> clinic -> name);
?>

<nav class="breadcrumb bg-faded no-gutters">
    <a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
    <a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl('home/news',['area' => $area],'&',false,true);; ?>">Новости</a>
    <a class="breadcrumb-item col-auto" href="<?php echo $url; ?>"><?php echo $model -> heading ? $model -> heading : 'Новость '.$model -> id; ?></a>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-12">
            <?php if ($model -> heading) : ?>
                <h1><?php echo $model -> heading; ?></h1>
            <?php endif; ?>
            <?php
                echo $model -> text;
            ?>
            <div>
                <?php
                $from = $model -> getTimeAttr('validFrom');
                $to = $model -> getTimeAttr('validTo');
                $opened = false;
                if (($from)||($to)) {
                    if ($from) {
                        echo "<strong>". ($opened ? " с " : "C ") .date('j.m.Y',$from)."</strong>";
                        $opened = true;
                    }
                    if ($to) {
                        echo "<strong>".($opened ? " по " : "По ").date('j.m.Y',$to)."</strong>";
                        $opened = true;
                    }
                    echo $opened ? " в " : "В ";
                    echo 'клинике <a href=\''.$model -> clinic -> getUrl().'\'>"'.$model -> clinic -> name.'"</a> действует <strong>скидка</strong> ';
                    echo $model -> saleSize ? 'до '.$model -> saleSize : '' ;
                    if ($model -> research instanceof ObjectPrice) {
                        echo " на ";
                        $this -> renderPartial('/prices/_catalogLink',['model' => $model -> research,'triggers'=>['area'=>$area]]);
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="text-center">
                <h3><a href="<?php echo $clinic -> getUrl(); ?>"><?php echo $clinic -> name; ?></a></h3>
                <div>
                    <a href="<?php echo $clinic -> getUrl(); ?>"><img class="img-fluid" src="<?php echo $clinic->giveImageFolderRelativeUrl().'/'.$clinic -> logo; ?>" alt="<?php echo $clinic -> name; ?>"/></a>
                </div>
                <div>
                    <?php
                        if ($clinic -> partner == 1) {
                            if ($area == 'msc') {
                                $phone = Yii::app() -> phoneMSC;
                            } else {
                                $phone = Yii::app() -> phone;
                            }
                            echo "Телефон: <a href='tel:".$phone -> getUnformatted()."'>".$phone -> getFormatted()."</a>";
                        }
                    ?>
                </div>
                <div>
                    Клиника расположена по адресу: <?php echo $areaVal -> value.', '.$clinic -> address; ?>
                </div>
                <div>
                    <button class="btn signUpButton" data-city="<?php echo $area; ?>">Записаться</button>
                </div>
            </div>
        </div>
    </div>
    <!--noindex-->
    <div class="row">
        <div class="col">
        <?php
        $common = dataForStandardArticleCards();
        $this -> renderPartial('/article/renderList', array('articles' => $common));
        ?>
        </div>
    </div>
    <!--/noindex-->
</div>
