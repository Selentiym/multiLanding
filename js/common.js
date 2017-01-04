function onFormSubmit() {
	try {
		if (typeof yaCounter != 'undefined') {
			yaCounter.reachGoal('formSent');
		}
	} catch (err) {
		console.log(err);
	}
	var button = $(this).find(".order-button");
	var loader = $("<img/>",{
		src:baseUrl+"/img/loading.gif"
	});
	button.after(loader);
	button.hide();
	$.ajax({
		type: "GET",
		url: baseUrl + "/post",
		data: $("#callback").serialize()
	}).done(function() {
		alert("Спасибо за заявку!");
		setTimeout(function() {
			$.fancybox.close();
		}, 10);
		loader.remove();
		button.show();
	}).fail(function () {
		alert('Ошибка при отправке заявки. Пожалуйста, попробуйте еще раз или воспользуйтесь номером телефона со страницы.');
	});
	return false;
}
function EvaluateOnPageLoad () {

	$(".main_mnu_button").click(function() {
		$(".main_menu ul").slideToggle();
	});

	//Попап менеджер FancyBox
	//Документация: http://fancybox.net/howto
	$(".fancybox").fancybox();

	$("#callback").off("submit");
	//Аякс отправка форм
	//Документация: http://api.jquery.com/jquery.ajax/
	$("#callback").submit(onFormSubmit);

	$("#callback-registration").off("submit");
	$("#callback-registration").submit(onFormSubmit);
}


function form () {
	$("#callback-from-page, #callback-from-page").submit(onFormSubmit);
}

//Skidki!

function skidki(){

	var clock;
	clock = $('#clock').FlipClock({
		clockFace: 'DailyCounter',
		autoStart: false,
		defaultLanguage: 'rus',
		callbacks: {
			stop: function() {
				$('.message').html('Время вышло!')
			}
		}
	});
	var toTime = new Date();
	var toAdd = toTime.getDate() % 3 + 2;
	toTime.setMinutes(0);
	toTime.setSeconds(0);
	toTime.setHours(toAdd*24);
	var nowTime = new Date();
	clock.setTime(Math.floor((toTime - nowTime)/1000));
	clock.setCountdown(true);
	clock.start();
}

//Карта
function geo(){

	$(".map_adres_hide .delete").click(function(){
		$(this).parents(".map_adres_hide").animate({ opacity: "hide" }, "slow");
	});

	$('.map_clinic_marker').click(function(){
		$('.map_clinic_marker').not($(this)).parent().children('.map_clinic_description').hide(1000);
		$(this).parent().children('.map_clinic_description').toggle(1000);
	});

}



//Каруселька (слайдер на первом экране)
function carousel(){
	var owl = $(".carousel");
	owl.owlCarousel({
		items : 1,
		autoHeight : true,
		autoPlay : 30000,
		stopOnHover : true,
	});
	owl.on("mousewheel", ".owl-wrapper", function (e) {
		if (e.deltaY > 0) {
			owl.trigger("owl.prev");
		} else {
			owl.trigger("owl.next");
		}
		e.preventDefault();
	});
	$(".next_button").click(function() {
		owl.trigger("owl.next");
	});
	$(".prev_button").click(function() {
		owl.trigger("owl.prev");
	});
}


//Каруселька докторов
function doctors(){

	var owl2 = $(".carousel-doctors");
	owl2.owlCarousel({
		items : 4,
		autoHeight : true,
		stopOnHover : true,
		touchDrag : false,
		autoPlay : true
	});
	owl2.on("mousewheel", ".owl-wrapper", function (e) {
		if (e.deltaY > 0) {
			owl2.trigger("owl.prev");
		} else {
			owl2.trigger("owl.next");
		}
		e.preventDefault();
	});
	$(".next_button").click(function() {
		owl2.trigger("owl.next");
	});
	$(".prev_button").off("click");
	$(".prev_button").click(function() {
		owl2.trigger("owl.prev");
	});

}


// Открыть/Закрыть ответ
function faq(){
		$('.question').on('click', '.toggle-answer', function(){
			$(this).siblings('.answer').toggle(1000);
		});

		$('a.toggle-answer').click(function(){
			var a = $(this).text();
			if (a == "Ответ >>") {
				$(this).text("Свернуть ответ >>");
			}
			else{
				$(this).text("Ответ >>");
			}
		});
}
	
	
// Вкладки (блок "Наше оборудование")
function jelezo(){
		$('#tabs').tabulous({
			effect: 'scale'
		});

		$('#tabs2').tabulous({
			effect: 'slideLeft'
		});
}

//Цены
function prices() {
	//Заново активируем якорь
	if (window.location.hash) {
		var toAss = window.location.hash.replace("#","");
		window.location.hash = '';
		window.location.hash = toAss;
	}
}

// Фиксированный блок (навигация по органам)
	$(window).scroll(function bodyNav(){
		var $block1 = $("#navigation");
		var $block2 = $("#navigation-mobile");

		if (( $(this).scrollTop() > 450) &&  $block1.hasClass("default") && $(window).width() >= '1200' ){
			$block1.removeClass("default")
					.addClass("fixed transbg");
		} else if(($(this).scrollTop() <= 450) && $block1.hasClass("fixed")  && $(window).width() >= '1200') {
			$block1.fadeOut('fast',function(){
				$(this).removeClass("fixed transbg")
						.addClass("default")
						.fadeIn('fast');
			});
		}
		if ( $(this).scrollTop() > 450 &&  $(window).width() < '1200' ){
			$block2.css('display','block');
		}
	});//scroll

// Подсвечиваем пункты навигации по органам (в зависимости от того, присутствует ли на экране цены мрт,кт этого органа)
			
		function check_elem(elem, elem2) {
			if(elem.length && elem2.length){
			 
					if ($(document).scrollTop() + $(window).height() - 200 > elem.offset().top && elem.scrollTop() - elem.offset().top < elem.height())
						{
							elem2.css("border","1px dashed rgb(0, 90, 197)");
							elem2.css("border-radius","50%");
						}
					else 	elem2.css("border","none");
				 
			}	
		}		
			

		$(window).scroll(function() {
				check_elem($("li.price-head"),$("#price_head"));
				check_elem($("li.price-pozv"),$("#price_pozv"));
				check_elem($("li.price-br"),$("#price_br"));
				check_elem($("li.price-taz"),$("#price_taz"));
				check_elem($("li.price-sust"),$("#price_sust"));
				check_elem($("li.price-org"),$("#price_org"));
				check_elem($("li.price-heart"),$("#price_heart"));
				check_elem($("li.price-kon"),$("#price_kon"));
				check_elem($("li.price-grud"),$("#price_grud"));
		});
	
	
	
	
	
// Фиксированные отзывы
	$(window).scroll(function settleReviews(){
		var $reviews = $("#reviews > div.reviews-inner");
		if ($(this).scrollTop() > 450){
			$reviews.addClass("fixed")
					.css({
						'top': '85px',
						'bottom':'0',
						'overflow-y':'scroll',
						'overflow-x':'hidden',
						'width':'250px',
						'left': '77%',
						'background-color': '#f7f7f7',
						'padding-top': '40px'
					});
		} else if($(this).scrollTop() <= 450) {
			$reviews.removeClass("fixed")
					.css({
						'overflow-y':'hidden',
						'padding-top': '0px',
						'width':'230px'
					});
		}
	});//scroll


// Фиксированный блок навигации по секциям
	$(window).scroll(function sectionsNav(){
		var $scrollblock = $("#arrow");
		if ( $(this).scrollTop() > 400){
			$scrollblock.css('display','block');
		}else if($(this).scrollTop() <= 400){
			$scrollblock.css('display','none');
		}
	});//scroll


	
// Появление "Записаться" в верхнем меню при прокрутке вниз
	$(window).scroll(function headFix(){
		var callback = $("#callback-on-fix-menu");
		var logotext = $("#logo-text");
		var orderbutton = $("#order-button");
		var logoouter = $("#logo-outer");
        var promo = $("span.promokod span");
        var promohand = $("span.promokod i");

		if ( $(this).scrollTop() > 150 ){
			callback.css('display','block');
			logotext.css('display','none');
			logoouter.removeClass("col-lg-3");
			logoouter.addClass("col-lg-1");
			logoouter.find(".logo").removeClass("col-lg-3")
								   .addClass("col-lg-12");
			promo.addClass("blink");					   
			promohand.css("display","inline-block");					   
		} else if($(this).scrollTop() <= 150) {
			callback.css('display','none');
			logotext.css('display','block');
			logoouter.removeClass("col-lg-1");
			logoouter.addClass("col-lg-3");
			logoouter.find(".logo").removeClass("col-lg-12")
								   .addClass("col-lg-3");
			promo.removeClass("blink");					   
			promohand.css("display","none");					   
		}
		if($(window).width() <= '1200') {
			logotext.css('display','none');
			callback.css('display','none');
		}

	});//scroll
	
	


	
	
	
	
	
$(document).ready(EvaluateOnPageLoad);
$(document).ready(carousel);
$(document).ready(gotoPrevNext);
//$(document).ready(doctors);
//$(document).ready(faq);
//$(document).ready(jelezo);
//$(document).ready(geo);



// Функции для отображения карты
			function changeCursor(){
				return false;
			var x = y = 0;
                var event = event || window.event;

                // Получаем координаты клика по странице, то есть абсолютные координаты клика.

                if (document.attachEvent != null) { // Internet Explorer & Opera
                    x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                    y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                } else if (!document.attachEvent && document.addEventListener) { // Gecko
                    x = event.clientX + window.scrollX;
                    y = event.clientY + window.scrollY;
                }

                //Определяем границы объекта, в нашем случае картинки.

                y0=document.getElementById("kartina").offsetTop;
                x0=document.getElementById("kartina").offsetLeft;

                // Пересчитываем координаты и выводим их алертом.

                x = x-x0;
                y = y-y0;
				
				//alert(x+'|'+y);
				
				if(x > 220 && x < 250){
                   document.body.style.cursor = 'pointer';
					//alert(x+'|'+y);
                        
                }else
                    if (x > 270 && x < 300 && y > 130 && y < 160){
                     document.body.style.cursor = 'pointer';
                 }else
                    if (x > 120 && x < 155 && y > 360 && y < 400){
                        document.body.style.cursor = 'pointer';
                 }else
                    if (x > 200 && x < 225 && y > 62 && y < 90){
                       document.body.style.cursor = 'pointer';
                 }else
                    if (x > 180 && x < 205 && y > 250 && y < 275){
                        document.body.style.cursor = 'pointer';
                 }else
                    if (x > 146 && x < 170 && y > 224 && y < 250){
                        document.body.style.cursor = 'pointer';
				}else
                    if (x > 105 && x < 130 && y > 165 && y < 190){
                       document.body.style.cursor = 'pointer';
				}else
                    if (x > 95 && x < 120 && y > 155 && y < 180){
                       document.body.style.cursor = 'pointer';
				}else
                    if (x > 160 && x < 185 && y > 130 && y < 155){
                        document.body.style.cursor = 'pointer';
				}else {document.body.style.cursor = 'default';}

				
			};
            function defPosition(event) {
				return false;
                var x = y = 0;
                var event = event || window.event;

                // Получаем координаты клика по странице, то есть абсолютные координаты клика.

                if (document.attachEvent != null) { // Internet Explorer & Opera
                    x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                    y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                } else if (!document.attachEvent && document.addEventListener) { // Gecko
                    x = event.clientX + window.scrollX;
                    y = event.clientY + window.scrollY;
                }

                //Определяем границы объекта, в нашем случае картинки.

                y0=document.getElementById("kartina").offsetTop;
                x0=document.getElementById("kartina").offsetLeft;

                // Пересчитываем координаты и выводим их алертом.

                x = x-x0;
                y = y-y0;

               //alert(x+'|'+y);

                var t = document.getElementById('map_adres1');
                var g = document.getElementById('map_adres2');
                var u = document.getElementById('map_adres3');
                var p = document.getElementById('map_adres6');
                var l = document.getElementById('map_adres5');
                var w = document.getElementById('map_adres4');
				var yi = document.getElementById('map_adres7');
				var map8 = document.getElementById('map_adres8');
				var map9 = document.getElementById('map_adres9');
				var map10 = document.getElementById('map_adres10');
				var map10_2 = document.getElementById('map_adres10_2');
				var map11 = document.getElementById('map_adres11');
                if(x > 220 && x < 250 && y > 154 && y < 210){
                    if(t.style.display =='block')
                        {t.style.display = 'none'}
                            else{t.style.display ='block'}
                }/*else
                    if (x > 140 && x < 170 && y > 50 && y < 80){
                        if(g.style.display =='block')
                        {g.style.display = 'none'}
                        else{g.style.display ='block'}
                 } */else
                    if (x > 270 && x < 300 && y > 130 && y < 160){
                      /* document.body.style.cursor = 'pointer';*/
					   if(u.style.display =='block')
                        {u.style.display = 'none'}
                        else{u.style.display ='block'}
                 }else
                    if (x > 120 && x < 155 && y > 360 && y < 400){
                        if(p.style.display =='block')
                        {p.style.display = 'none'}
                        else{p.style.display ='block'}
                 }/*else
                    if (x > 45 && x < 75 && y > 330 && y < 360){
                        if(l.style.display =='block')
                        {l.style.display = 'none'}
                        else{l.style.display ='block'}}*/
				/*else
                    if (x > 250 && x < 280 && y > 300 && y < 340){
                        if(w.style.display =='block')
                        {w.style.display = 'none'}
                        else{w.style.display ='block'}
                 }*/else
                    if (x > 200 && x < 225 && y > 62 && y < 90){
                        if(yi.style.display =='block')
                        {yi.style.display = 'none'}
                        else{yi.style.display ='block'}
                 }else
                    if (x > 180 && x < 205 && y > 250 && y < 275){
                        if(map8.style.display =='block')
                        {map8.style.display = 'none'}
                        else{map8.style.display ='block'}
                 }else
                    if (x > 146 && x < 170 && y > 224 && y < 250){
                        if(map9.style.display =='block')
                        {map9.style.display = 'none'}
                        else{map9.style.display ='block'}
				}else
                    if (x > 105 && x < 130 && y > 165 && y < 190){
                        if(map10_2.style.display =='block')
                        {map10_2.style.display = 'none'}
                        else{map10_2.style.display ='block'}
				}else
                    if (x > 95 && x < 120 && y > 155 && y < 180){
                        if(map10.style.display =='block')
                        {map10.style.display = 'none'}
                        else{map10.style.display ='block'}
				}else
                    if (x > 160 && x < 185 && y > 130 && y < 155){
                        if(map11.style.display =='block')
                        {map11.style.display = 'none'}
                        else{map11.style.display ='block'}
				}


               /*if (x > 250 && x < 280 && y > 300 && y < 340){
                    alert('da6!');
                }*/


            }
			
	// Перейти к следующей/предыдущей SECTION
	
		var pagePositon = 0,
				$scrollItems = $('section'),
				offsetTolorence = 30,
				pageMaxPosition = $scrollItems.length - 1;
		function reNewSectionSet(){
			$scrollItems = $('section');
			offsetTolorence = 30;
			pageMaxPosition = $scrollItems.length - 1;
			
			//Map the sections:
			$scrollItems.each(function(index,ele) { $(ele).attr("debog",index).data("pos",index); });
		}

		function gotoPrevNext(){
			// Bind to scroll
			$(window).bind('scroll',upPos);

			reNewSectionSet();

			//Move on click:
			$('#arrow a').click(function(e){
				console.log(pagePositon, pageMaxPosition);
				if (!pagePositon) {
					pagePositon = 0;
				}
				if ($(this).hasClass('next')) {
					pagePositon++;
					if ($scrollItems.eq(pagePositon).offset()) {
						$('html, body').stop().animate({
							  scrollTop: $scrollItems.eq(pagePositon).offset().top
						}, 300);
					}
					if (pagePositon > pageMaxPosition) {
						pagePositon = pageMaxPosition;
					}
				}
				if ($(this).hasClass('previous') && pagePositon-1 >= 0) {
					pagePositon--;
					if ($scrollItems.eq(pagePositon).offset()) {
						$('html, body').stop().animate({
							  scrollTop: $scrollItems.eq(pagePositon).offset().top
						  }, 300);
						  if (pagePositon < 0) {
							pagePositon = 0;
						}
					}
					return false;
				}
			});

			//Update position func:
			function upPos(){
			   var fromTop = $(this).scrollTop();
			   var $cur = null;
				$scrollItems.each(function(index,ele){
					if ($(ele).offset().top < fromTop + offsetTolorence) $cur = $(ele);
				});
			   if ($cur != null && pagePositon != $cur.data('pos')) {
				   pagePositon = $cur.data('pos');
			   }
			}

		}	