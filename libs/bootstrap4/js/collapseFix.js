/**
 * Created by user on 19.04.2017.
 */
$(document).ready(function(){
    $('.tabControl').click(function(){
        var selector = $(this).attr('data-target');
        var listId = $(this).attr('data-tablist-id');
        if (listId) {
            $('[data-tablist-id='+listId+']').each(function(ind, obj){
                try {
                    $($(obj).attr('data-target')).collapse('hide');
                } catch (e) {}
            });
        }
        try {
            $($(this).attr('data-target')).collapse('show');
        } catch (e){}
    });
});