<?php
/**
 *
 * @var Section $section
 * @var \Rule $rule
 */
//$view = preg_match('////', $section -> view) ? $section -> view : '//subs_thirdDesign/'.$section -> view;
if ($section -> ajax) {
    $id = $section -> view.'_loader';
    $tel = json_encode($tel);
    echo "<div id='$id' class='sectionLoader'>ajax</div>";
    Yii::app() -> getClientScript() -> registerScript("load".$id,"
        $.post('".Yii::app() -> baseUrl."/site/block',{
            section_id:$section->id,
            rule_id:$rule->id,
            tel:$tel
        },null,'html').done(function(data){
            $('#$id').replaceWith(data);
            EvaluateOnPageLoad();
        });
    ",CClientScript::POS_READY);
} else {
    $this->renderPartial('//subs_thirdDesign/' . $section->view, array('model' => $rule, 'base' => $base, 'tel' => $tel));
}
?>