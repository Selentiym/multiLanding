/**
 * Created by user on 11.08.2017.
 */
$(document).ready(function(){
    var $images = $('img.lazyLoad');
    var boundary = 300 + screen.height;
    $(document).on("scroll.lazyLoad",function(){
        $images = $.grep($images, function(el, ind){
            var rect = el.getBoundingClientRect();
            if (rect.top < boundary) {
                el.setAttribute("src", el.getAttribute("data-src"));
                //remove element from array
                return false;
            }
            //conserve the element, since it is not the time yet
            return true;
        });
        //Чтобы потом не грузить браузер
        if ($images.length == 0) {
            $(document).off("scroll.lazyLoad");
        }
    });
    //$images.each(function(){
    //
    //});
});