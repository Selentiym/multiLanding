<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2017
 * Time: 14:57
 */
/**
 * @type Comment[] $comments
 * @type integer $object_id
 * @type string $id
 * @type int[] $ids
 */
Yii::app() -> getClientScript() -> registerScript('VKComments'.$id,"

    new VKCommentsModuleWidget({
        element:$('#$id'),
        ids:".json_encode(array_values($ids))."
    });

",CClientScript::POS_READY);
?>
    <div class="reviews vkbody" id="<?php echo $id; ?>">
        <div class="wcomments_page _wcomments_page wcomments_section_posts">
            <div class="wcomments_head _wcomments_head clear_fix">
				<span class="wcomments_count _wcomments_count">
					<?php
                    $total = count($ids);
                    $word = 'комментари';
                    $num = $total%10;
                    if (($num == 0)||($num >= 5)||(($num >= 10)&&($num <= 20))) {
                        $word .= 'ев';
                    } elseif ($num == 1) {
                        $word .= 'й';
                    } elseif (($num >= 2) && ($num <= 4)) {
                        $word .= 'я';
                    }
                    echo $total.' '.$word;
                    ?> </span>
            </div>

            <div class="_wcomments_content wcomments_content">
                <div class="_wcomments_form clear_fix">
                    <div class="wcomments_form" style="display:none">
                        <div class="box_error wcomments_post_error submit_post_error"></div>
                        <a href="http://vk.com" class="wcomments_form_avatar vk_avatar_link"><img class="vk_avatar_round_small" src="http://vk.com/images/camera_50.png"></a>
<!--                        <div id="submit_post_box" class="wcomments_post_box shown clear_fix">-->
                        <div class="submit_post_box wcomments_post_box shown clear_fix">
                            <div class="_emoji_field_wrap">
                                <div class="wcomments_post_field dark submit_post_inited post_field" contenteditable="true"></div>
                                <div class="placeholder"><div class="ph_input"><div class="ph_content">Ваш комментарий...</div></div></div></div>
                            <div class="submit_post wcomments_submit_post clear_fix">
<!--                            <div id="submit_post" class="wcomments_submit_post clear_fix">-->
                                <div class="clear_fix media_preview"></div>
                                <div class="addpost_button_wrap reply_box_main">
                                    <button class="flat_button addpost_button send_post">Отправить</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="wcomments_form" style="text-align:center">
                        <button class="flat_button show_input">Оставить свой отзыв</button>
                    </div>
                </div>

                <div class="_wcomments_posts_outer wcomments_posts_outer no_post_click wall_module wide_wall_module">
                    <div class="wcomments_posts_inner">
                        <div class="wcomments_posts">
                            <?php
                            //$this -> renderPartial('//landingLike/commentsPage',['page' => 0]);
                            ?>
                            <div class='showMoreReviews flat_button addpost_button send_post' style='text-align:center;mergin-top:10px;'>Показать еще</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $form=$this->beginWidget('CActiveForm', array(
            'htmlOptions' => [
                'class'=>'comment-form',
            ],
            'action'=> $this -> createUrl('admin/addReview'),
        ));
        /**
         * @type CActiveForm $form
         */
        $comment = new Comment();
        $comment -> id_object = $object_id;
        echo $form -> hiddenField($comment, 'text', ['class' => 'ReviewTextHidden']);
        echo $form -> hiddenField($comment, 'vk_id', ['class' => 'VkIdHidden']);
        echo $form -> hiddenField($comment, 'id_object');
        $this->endWidget();
        ?>
    </div>
