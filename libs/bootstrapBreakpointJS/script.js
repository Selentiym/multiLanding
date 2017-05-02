/**
 * Created by user on 02.05.2017.
 */
$(document).ready(function(){
    $('body').append('<div class="device-xs hidden-sm-up">1</div><div class="device-sm hidden-md-up">2</div><div class="device-md hidden-lg-up">3</div><div class="device-lg hidden-xl-up">4</div>');
    window.isBreakpoint= function ( alias ) {
        return !$('.device-' + alias).is(':visible');
    }
});