<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.08.2017
 * Time: 11:59
 *
 * @type News $model
 */
$area = $model -> clinic -> getFirstTriggerValue('area') -> verbiage;
$link = $this -> createUrl('home/showNews',['area' => $area,'id' => $model -> id],'&',false,true);
?>
<div class="card mb-3">
    <?php if ($model -> heading) : ?>
        <div class="card-header">
            <h3><a href="<?php echo $link; ?>"><?php echo $model -> heading; ?></a></h3>
        </div>
    <?php endif; ?>

    <div class="card-block row">
        <div class="card-image col-12 col-md-3">
            <a href="<?php echo $model -> clinic -> getUrl(); ?>"><img class="img-fluid" src="<?php echo $model -> clinic -> giveImageFolderRelativeUrl() . $model -> clinic -> logo;?>" title="<?php echo $model -> clinic -> name; ?>"  alt="<?php echo $model -> clinic -> name; ?>"/></a>
        </div>
        <div class="card-text col-12 col-md-9">
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
            echo "<div><a href='".$link."'><button class='btn'>Подробнее</button></a></div>"
            ?>
        </div>
    </div>
</div>
