<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2017
 * Time: 18:58
 * @type HomeController $this
 */
$triggers = $_GET;
?>
<div class="conteiner-fluid p-3">
    <div class="row">
        <div class="col-12 col-md-10 mx-auto">
            <div class="col-12 col-md-6">
                <h2>Москва</h2>
                <?php $triggers['area'] = 'msc'; ?>
                <a href="<?php echo $this -> createUrl('home/clinics',$triggers); ?>"><button class="btn">Искать в Москве и пригородах</button></a>
                <div>

                </div>
            </div>
            <div class="col-12 col-md-6">
                <h2>Санкт-Петербург</h2>
                <?php $triggers['area'] = 'spb'; ?>
                <a href="<?php echo $this -> createUrl('home/clinics',$triggers); ?>"><button class="btn">Искать в Санкт-Петербурге и пригородах</button></a>
                <div>

                </div>
            </div>
        </div>
    </div>
</div>