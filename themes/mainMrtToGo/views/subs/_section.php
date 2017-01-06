<?php
/**
 *
 * @var Section $section
 * @var \CommonRule $rule
 */
//$view = preg_match('////', $section -> view) ? $section -> view : '//subs/'.$section -> view;
if ($section -> ajax) {
    $id = $section -> view.'_loader';
    //$tel = json_encode($tel);
    echo "<div id='$id' class='sectionLoader'><img src='".$base."/img/loading.gif' /></div>";
    $params = [
        "section_id" => $section->id,
        "rule_id" => $rule->id,
        "tel" => $tel,
        "utm_term" => $_GET["utm_term"]
    ];
    Yii::app() -> getClientScript() -> registerScript("load".$id,"
        $.post('".Yii::app() -> baseUrl."/site/block',".json_encode($params).",null,'html').done(function(data){
            $('#$id').replaceWith(data);
			
			reNewSectionSet();
            
			if (typeof $section->view == 'function') {
                $section->view();
            }
			
			
        });
    ",CClientScript::POS_READY);
} else {
    $this->renderPartial('//subs/' . $section->view, array('model' => $rule, 'base' => $base, 'tel' => $tel));
}
?>