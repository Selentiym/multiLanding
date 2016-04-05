<?php if (!$noHeading) : ?>
<div class="blocks_label">
	<span class="label_img"></span><span class="label_text"><?php echo $label; ?></span>
</div>
<?php
	endif;
	foreach ($blocks as $bl) {
		if ($bl -> id != $block -> id) {
			$this -> renderPartial('//subs/_price_block', array('block' => $bl, 'id' => $id, 'opened' => false, 'noHeading' => false));
		}
	}
?>