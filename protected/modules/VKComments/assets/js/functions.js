/**
 * Created by user on 27.03.2017.
 */
//function addMoreReviews(id) {
//    var toReplace = $("#showMoreReviews");
//    toReplace.html($("<img>",{
//        src:baseUrl+"/img/loading.gif",
//        css:{height:"20px", width:"20px"}
//    }));
//    $.post(baseUrl + "/moreReviews",{
//        currentPage: page,
//        objectInfo:{id: id}
//    }).done(function(data){
//        if ((data)&&(toReplace)) {
//            toReplace.replaceWith(data);
//            page ++;
//        }
//    });
//}
function VKCommentsModuleWidget(params){
    var me = {};
    me.page = 0;
    me.element = params.element;
    me.ids = params.ids;


    me.form = me.element.find('.comment-form');
    me.textField = me.element.find('.post_field');
    me.textForm = me.element.find('.ReviewTextHidden');
    me.placeholder = me.element.find('.placeholder');
    me.submitButton = me.element.find('.send_post');
    me.commentContainer = me.element.find('.wcomments_posts');

    me.textField.keyup(function(){
        if ($(this).html().length > 0) {
            me.placeholder.hide();
        } else {
            me.placeholder.show();
        }
    });
    me.addMoreReviews = function () {
        var toReplace = me.element.find(".showMoreReviews");
        toReplace.html($("<span>",{
            "class":"vkCommentsLoading"
        }));

        $.post(VKCommentsModule.baseUrl + "/admin/getReviewsHtml",{
            currentPage: me.page,
            ids: me.ids
        }).done(function(data){
            if ((data)&&(toReplace)) {
                toReplace.replaceWith(data);
                me.element.find(".showMoreReviews").click(function(){
                    me.addMoreReviews();
                });
                me.page ++;
            }
        });
    };
    //me.element.find('.send_post').click(function(){
    //    alert('send!');
    //    me.element.find('.ReviewTextHidden').val(me.element.find('.post_field').html());
    //    me.element.find('.comment-form').submit();
    //});

    me.submitButton.click(function(){
        me.addNewReview();
    });
    me.addNewReview = function(){
        me.textForm.val(me.textField.html());
        var tempLoading = $('<span>',{
            "class":"vkCommentsLoading"
        });
        //me.submitButton.after();
        me.submitButton.html(tempLoading);
        $.post(VKCommentsModule.baseUrl + '/admin/addReview',me.form.serialize(),function(){},"JSON").done(function(data){
            if (data.success) {
                me.textForm.val('');
                me.textField.html('');
                me.placeholder.show();
                me.submitButton.html('Отправить');
                if (data.html) {
                    me.commentContainer.prepend(data.html);
                }
            }
            //if (data.success) {
            //    alert("Отзыв успешно добавлен");
            //}
        }).always(function(){
            tempLoading.remove();
            me.submitButton.show();
        });
    };
    me.addMoreReviews();
    return me;
}