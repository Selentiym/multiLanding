/**
 * Copyright 2014 by Anton Kuliashou
 * Free to use any way you like.
 * Site: http://falbar.ru/
*/

(function($){

	jQuery.fn.smartScrollToTop = function(options){

		var element = this,
			inAnimate = false;

		var method = {
			showButton: function(){

				$(window).scroll(function(){

					if($(this).scrollTop() > 300){

						element.fadeIn(settings.fadeIn);
					};

					if($(this).scrollTop() > 300 && element.hasClass(settings.classInTop)){

						element.removeClass(settings.classInTop);
						element.removeClass(settings.classInAct);
					};

					if($(this).scrollTop() < 300 && !element.hasClass(settings.classInTop) && !inAnimate){

						element.fadeOut(settings.fadeOut);
					};
				});

				return false;
			},
			scroll: function(pos, flag, el){

				if (settings.speed === false){
					settings.speed = 0;
				};

				inAnimate = true;

				$("html, body").stop()
					.animate({
						scrollTop: pos
					}, settings.speed, function(){

						if(flag == "add"){
							el.addClass(settings.classInTop);
						}else{
							el.removeClass(settings.classInTop);
						};

						inAnimate = false;
					});

				return false;
			}
		};

		var settings = $.extend({

			speed: false,
			classInTop: "up",
			classInAct: "scroll-to-back",
			fadeIn: 600,
			fadeOut: 600

		}, options);

		return this.each(function(){

			method.showButton();

			element.on("click", function(){

				if(!$(this).hasClass(settings.classInAct)){

					$(this).addClass(settings.classInAct);
					topPos = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
					method.scroll(0, "add", $(this));
	
				}else{

					$(this).removeClass(settings.classInAct);
					method.scroll(topPos, "remove", $(this));
				};

				return false;
			});
		});
	};

})(jQuery);