<?php
/**
 *
 * @var Section $section
 * @var \Rule $rule
 */
//$view = preg_match('////', $section -> view) ? $section -> view : '//subs_thirdDesign/'.$section -> view;
$this -> renderPartial('//subs_thirdDesign/'.$section -> view,array('model' => $rule,'base' => $base, 'tel' => $tel));
?>