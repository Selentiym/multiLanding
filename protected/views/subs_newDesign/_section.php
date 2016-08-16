<?php
/**
 *
 * @var Section $section
 * @var \Rule $rule
 */
//$view = preg_match('////', $section -> view) ? $section -> view : '//subs_newDesign/'.$section -> view;
$this -> renderPartial('//subs_newDesign/'.$section -> view,array('model' => $rule));
?>