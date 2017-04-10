/**
 * Created by user on 10.04.2017.
 */
$(document).ready(function(){
    var el = $('<a>', {
        href:"#",
        id:"totop"
    });
    $('body').prepend(el);
    el.smartScrollToTop({
        speed: 1000,
        classInTop: "up",
        classInAct: "scroll-to-back",
        fadeIn: 600,
        fadeOut: 600
    });
});