<?php
/**
 * @type string $url
 * @type string $name
 * @type string $description
 * @type string $imageUrl
 */
?>
<div class="col-md-4 col-12 p-1">
    <div  class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h4 class="mb-1 text-center w-100"><a  href="<?php echo $url; ?>"><?php echo $name; ?></a></h4>
        </div>
        <div class="text-center w-100"><img class="m-1" style="max-height: 300px; max-width:100%;" src="<?php echo $imageUrl; ?>" alt="<?php echo $name; ?>"/></div>
        <p class="mb-1"><?php echo $description;?></p>
    </div>
</div>